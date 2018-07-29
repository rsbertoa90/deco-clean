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
                        :events="futureEvents(selectedSeminar)" key="events">
                        <button @click="component='seminars'" >Atras</button>
            </app-events>
        </transition>
    </div>


</template>

<script>
import appSeminars from './crud/Seminars.vue';
import appEvents from './crud/Events.vue';
import {SeminarsMixin} from '../../mixins/seminars.js';
export default {
    mixins :[SeminarsMixin],
    components: {
        appSeminars : appSeminars,
        appEvents : appEvents
    },
    data(){
        return {
            component : 'seminars',
            selectedSeminar : null,
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

