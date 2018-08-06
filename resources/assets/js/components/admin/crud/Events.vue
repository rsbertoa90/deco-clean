<template>
    <div>
        <slot></slot>
        <h3 v-if="events.length>0" >Proximos eventos: {{seminar.title}}</h3>
        <table v-if="events.length>0"  class="table table-striped table-bordered">
            <thead>
                <th>Lugar</th>
                <th>Fecha y hora</th>
                <th>Cupo</th>
                <th>Precio</th>
            </thead>
            <transition-group tag="tbody"
                              leave-active-class="animated slideOutRight faster"
                              enter-active-class="animated slideInLeft faster">
               <event-row v-for="(event,key) in events" :evkey="key" :key="key"
                          :event="event" :states="states" 
                          @save="save"></event-row> 
            </transition-group>
        </table>
        <hr>
        <ev-create @eventCreated="eventCreated" :seminar="seminar"></ev-create>
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
import { citiesMixin } from '../../../mixins/cities.js';
import evCreate from './Event-create.vue';
import eventRow from './Event-row.vue';
export default {
    props:['seminar'],
    mixins :[citiesMixin],
    components : {evCreate,eventRow},
    data(){
        return{
            events : [],
        }
    },

    
   created(){
       var vm = this;
        this.$http.get('/api/event/future/'+vm.seminar.id)
            .then(response=>{
                vm.events = response.data;
                // console.log(vm.events);
            });
        
   },
    methods:{
        eventCreated(event){
            if (event.mode == 'presencial'){
                event.state = this.states.find(el=>{return el.name == event.state});
            }
            // console.log(event.date);
            // event.date = moment(event.date).format('YY/MM/DD');
            this.events.push(event);
        },
        del(event){
            var vm =this;
            // console.log(event.inscriptions);
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
            // console.log(e.event[e.field]);

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
      
     
    }
}
</script>
