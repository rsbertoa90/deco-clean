<template>
    <div>
        <transition  
                    leave-active-class="animated fadeOutDown faster position-fixed"
                    enter-active-class=""
                   mode="in-out">
        
       
            <app-seminars v-if="component == 'seminars'"
                        :seminars="seminars" 
                        @updatedSeminar="updateSeminar"
                        @seminarDeleted="deleteSeminar"
                        @seminarCreated="createSeminar"
                        @showEvents="showEvents" key="seminars"></app-seminars>

            <app-events v-if="component == 'events'"           
                        :seminar ="selectedSeminar"
                        key="events">
                        <button @click="component='seminars'" class="btn btn-outline-info" >Atras</button>
            </app-events>
        </transition>
    </div>


</template>

<script>
import { EventBus } from '../../app.js';
import appSeminars from './crud/Seminars.vue';
import appEvents from './crud/Events.vue';
import {SeminarsMixin} from '../../mixins/seminars.js';
export default {
    mixins :[SeminarsMixin],
    components: {
        appSeminars : appSeminars,
        appEvents : appEvents
    },
    created(){
        var vm =this;

        

        EventBus.$on('newEvent', event => {
            for (const key in vm.seminars) {
                if (vm.seminars.hasOwnProperty(key)) {
                    const sem = vm.seminars[key];
                    if (event.seminar_id == sem.id)
                    {
                        
                        vm.seminars[key].events.push(event);
                        vm.selectedSeminar = vm.seminars[key];
                        return;
                    }
                }
            }
        });
    },
    data(){
        return {
            component : 'seminars',
            selectedSeminar : null,
        }
    },
    computed : {
        future(){
           
            
            return this.futureEvents(this.selectedSeminar);
        }
    },
    methods :{
       
        showEvents(event){
            this.selectedSeminar = event;
            this.component = 'events'
        },
        createSeminar(event)
        {
            this.seminars.push(event);
        },
        updateSeminar(event){
            for (const key in this.seminars) {
                if (this.seminars.hasOwnProperty(key)) {
                    const element = this.seminars[key];
                    if (element.id == event.seminarId){
                        this.seminars[key][event.field] =event.value;
                        // console.log(this.seminars[key][event.field]);
                        return;
                    }
                }
            }   
        },
        deleteSeminar(event){
            var vm = this;
            for (const key in this.seminars) {
                if (this.seminars.hasOwnProperty(key)) {
                    const element = this.seminars[key];
                    if (element.id == event){
                        vm.seminars.splice(key,1);
                        return;
                    }
                }
            }   
        },
    }
}
</script>

