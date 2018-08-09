<template>
    <div>
       
        <h3 v-if="city"> {{city.name}} </h3>
        <h3 v-else> ONLINE </h3>
        <table v-if="events.length > 0"  class="table table-striped table-bordered">
            <thead>
                <th>Seminario</th>
                <th>Fecha y hora</th>
                <th>Cupo</th>
                <th>Precio</th>
            </thead>
            <transition-group tag="tbody"
                              leave-active-class="animated slideOutRight faster"
                              enter-active-class="animated slideInLeft faster">
               <event-row 
                          v-for="(event,key) in events" :evkey="key" :key="key"
                          :event="event" :states="states" 
                          @save="save"></event-row> 
            </transition-group>
        </table>
        <hr>
        <ev-create  :mode="mode" :city="city">
        </ev-create>
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
import { citiesMixin } from '../../../mixins/cities.js';
import evCreate from './Event-create.vue';
import eventRow from './Event-row.vue';
export default {
    props:['city','mode'],
    mixins :[citiesMixin],
    components : {evCreate,eventRow},
    data(){
        return{
            events : [],
           
        }
    },

    
  
    methods:{
        eventCreated(event){
            this.events.push(event);
        },
        del(event){
            var vm =this;
           
            if (event.inscriptions != null && event.inscriptions.length > 0){
                swal( 'Hay inscripciones en este evento',
                       'Desea cancelar el evento? . El dinero de los pagos quedara como saldo a favor de los usuarios.',
                        'warning',
                        {buttons :true,
                        dangerMode:true})
                        .then(response => {
                            if (response){
                                vm.$http.delete('/admin/event/'+event.id);
                                for (const key in vm.events) {
                                    if (vm.events.hasOwnProperty(key)) {
                                        const ev = vm.events[key];
                                        if (event.id == ev.id)
                                        {
                                            vm.events.splice(key,1);
                                        }
                                    }
                                }
                                EventBus.$emit('eventDeleted',event);
                                
                            }
                        })
            }else{
                this.$http.delete('/admin/event/'+event.id);
                EventBus.$emit('eventDeleted',event);
                 for (const key in vm.events) {
                                    if (vm.events.hasOwnProperty(key)) {
                                        const ev = vm.events[key];
                                        if (event.id == ev.id)
                                        {
                                          
                                            vm.events.splice(key,1);
                                            
                                        }
                                    }
                                }
            }
        },
        save(e){
            var vm=this;
    

            var data = {
                id: e.event.id,
                field : e.field,
                value : e.event[e.field]
            }
           
            this.$http.put('/admin/event',data)
                .then(response=>{
                    vm.events[e.evkey][e.field] = e.event[e.field];
                });

        },
    
    },
    computed : {
        
    },
    watch: {
      city(){
          var vm= this;
          if(this.city){
                vm.$http.get('/api/events/by-city/'+vm.city.id)
                    .then(response => {
              
                vm.events = response.data;
                });
          }
    
          
      },

      mode(){
           var vm = this;
          if (this.mode == 'online')
          {
               vm.$http.get('/api/events/online')
                    .then(response => {
        
                vm.events = response.data;
            });
          }
     
      }
     
    },
    created(){
        var vm = this;
        vm.$http.get('/api/events/online')
            .then(response => {
                vm.events = response.data;
             
            });
         EventBus.$on("eventCreated",this.eventCreated);
    },
}
</script>
