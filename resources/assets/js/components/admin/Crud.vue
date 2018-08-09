<template>
    <div>
        <div class="w-100 row">
            <div class="col-12 col-lg-2">
                <app-cities @citySelected="setSelectedCity"
                            @online="setOnline"></app-cities>
            </div>

            <div class="col-12 col-lg-10">
                 <transition  
                    leave-active-class="animated fadeOutDown faster position-fixed"
                    enter-active-class=""
                   mode="in-out">
        
        
                 

                    <app-events  
                                :mode="mode"
                                :city="selectedCity"        
                                key="events">
                    </app-events>
                </transition>
            </div>

        </div>
       
    </div>


</template>

<script>
import { EventBus } from '../../app.js';
import appSeminars from './crud/Seminars.vue';
import appEvents from './crud/Events.vue';
import appCities from './crud/Cities.vue';
import {SeminarsMixin} from '../../mixins/seminars.js';
export default {
    mixins :[SeminarsMixin],
    components: {
        appSeminars : appSeminars,
        appEvents : appEvents,
        appCities,
    },
    data(){
        return {
             mode : 'online',
             selectedCity : null,

        }
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
  
    computed : {
        future(){
           
            
            return this.futureEvents(this.selectedSeminar);
        }
    },
    methods :{
        checkCity(){

        },
        setOnline()
        {
    
            this.selectedCity=null;
            this.mode = 'online'
        },
        setSelectedCity(event)
        {
            this.mode = 'presencial';
            this.selectedCity = event;
        }
    }
}
</script>

