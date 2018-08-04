<template>
    <div>
        <slot></slot>
        <h3 v-if="events.length>0" >Proximos eventos: {{seminar.title}}</h3>
        <table v-if="events.length>0"  class="table table-striped table-bordered">
            <thead>
                <th>Lugar</th>
                <th>Dia</th>
                <th>Cupo</th>
                <th>Precio</th>
            </thead>
            <transition-group tag="tbody"
                              leave-active-class="animated slideOutRight faster"
                              enter-active-class="animated slideInLeft faster">
                <tr v-for="event in events" :key="event.id">
                    <td v-if="event.mode == 'online'">
                        ONLINE
                    </td>
                    <td v-else>
                        <div class="row"> 
                            <div class="col-6 p2">
                                <select class="form-control" v-model="event.state" >
                                    <option v-for="state in states" :key="state.id"
                                            :value="state"> {{state.name}} </option>
                                </select>
                            </div> 
                            <div class="col-6 p2">
                                <select  class="form-control" v-if="event.state != null"  v-model="event.city" @change="saveCity(event)">
                                    <option  v-for="city in event.state.cities" :key="city.id"
                                            :value="city.name"> {{city.name}} </option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        
                        <div>
                            <input type="date" v-model.lazy="event.date" @change="save(event,'date')">
                            <input type="time" v-model.lazy="event.hour" @change="save(event,'hour')">
                        </div>
                    </td>
                    <td>
                        <input v-model.lazy="event.quota" @click="save(event,'quota')" 
                               type="number" min="0" class="form-control">
                    </td>
                    <td>
                        <div class="row">
                            <span class="col-1">$</span>
                            <input v-model.lazy="event.price" @change="save(event,'price')"
                                     type="number" min="0" class="form-control col-8">
                        </div>
                    </td>
                    <td>
                        <div>
                             <button class="btn btn-outline-danger" @click.prevent="del(event)">
                                 <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
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
export default {
    props:['seminar'],
    mixins :[citiesMixin],
    components : {evCreate},
    data(){
        return{
            events : [],
        }
    },

    
   created(){
       var vm = this;
       
        
        if (vm.seminar.events.length > 0){

            vm.events = this.seminar.events.filter(ev => {
                     return (new Date(ev.date)) >= Date.now();
                });
            
    
           for (const key in vm.events) {
               
               if (vm.events.hasOwnProperty(key)) {
                   const ev = vm.events[key];
                  
                   vm.events[key].date = moment(ev.date, 'YYYY-MM-DD' ).format('YYYY-MM-DD');
                   vm.events[key].hour =moment(ev.hour, 'HH:mm').format('HH:mm')
                
               }
           }
        }
   },
    methods:{
        eventCreated(event){
            if (event.mode == 'presencial'){
                event.state = this.states.find(el=>{return el.name == event.state});
            }
            console.log(event.date);
            this.events.push(event);
        },
        del(event){
            var vm =this;
            console.log(event.inscriptions);
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
        save(event,field){
            console.log(event[field]);
            var data = {
                id: event.id,
                field : field,
                value : event[field]
            }
            this.$http.put('/admin/event',data)
                .then(response=>{
 
                });

        },
        saveCity(event){
            var data = {
                id  : event.id,
                state : event.state.name,
                city : event.city,
                 }

            this.$http.put('/admin/event/update-city',data)
                .then(response=>{
                   
                    
                });

        },
         citiesIn(state)
        {
             var objstate = this.states.find(el => {
                 el.name == state;
             });
             if(objstate != null){
                 this.$http.get('/api/cities/'+objstate.id)
                     .then(response => {
                       
                         return response.data;
                     });
             } return [];
        },
        dateDay(date){
            return moment(new Date(date)).format('D/M/Y');
        },
        dateTime(date){
            return moment(new Date(date)).format('h:mm');
        }
    },
    computed : {
        
    },
    watch: {
        // events(){
        //     var vm=this;
        //     for (const key in vm.events) {
        //     if (vm.events.hasOwnProperty(key)) {
        //         const state = vm.events[key].state;
        //         if (typeof state != 'object'){
        //             vm.events[key].state = vm.states.find(el=>{return el.name == state});
        //         }
               
        //     }
        // }
        // },
       states(){
        var vm = this;
        for (const key in vm.events) {
            if (vm.events.hasOwnProperty(key)) {
                const state = vm.events[key].state;
                if (typeof state != 'object'){
                    vm.events[key].state = vm.states.find(el=>{return el.name == state});
                   
                }
               
            }
        }
       },
     
    }
}
</script>
