<template>
    <tr>
                 
                    <td >
                        <div class="row"> 
                           <select  @change="save('seminar_id')"
                                    v-model="event.seminar_id" 
                                    class="form-control">
                               <option v-for="seminar in seminars"
                                        :key="seminar.id"
                                        :value="seminar.id">
                                    {{seminar.title}}        
                                </option>
                           </select> 
                           
                        </div>
                    </td>
                    <td class="small">
                        
                        <div class="row">
                            <div class="col-12">
                                
                                <date-picker 
                                            format='dd/MM/yyyy' 
                                            v-model="date" 
                                            @input="save('date')"
                                            :disabledDates="disabledDates"> 
                                </date-picker>
                            </div>
                            <div class="col-12">
                                <time-picker  
                                                v-model="hora" 
                                                format="HH:mm"
                                                :minute-interval="15"
                                                @change="save('hour')"></time-picker>
                            </div>
                        </div>
                    </td>
                    <td  class="small">
                        <input v-model.lazy="event.quota" @change="save('quota')" 
                               type="number" min="0" class="form-control">
                    </td>
                    <td  class="small">
                        <div class="row">
                            <span class="col-1">$</span>
                            <input v-model.lazy="event.price" 
                                    @change="save('price')"
                                     type="number" min="0" 
                                     class="form-control col-8">
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
</template>

<script>
import {SeminarsMixin} from '../../../mixins/seminars.js'
import { EventBus } from '../../../app.js';
export default {
    mixins :[SeminarsMixin],
    props :['event','evkey','states'],
    watch : {
        states(){
            var vm = this;

            vm.event.state = vm.states.find(el=>{
                    return el.name == vm.event.state
                    });
            
        }
    },
    data(){
        return {
              disabledDates : {
                to : new Date()
            },
            hora:{
                HH : '',
                mm : ''
            },
            
            date: null,

        }
    },
    methods : {
        
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

       save(field){
           if (this.event.id == null){return;}
           if (field == 'hour')
           {
               this.event.hour = `${this.hora.HH}:${this.hora.mm}`;
           } else if (field == 'date')
           {
           
               this.event.date = moment(this.date).format('YYYY/MM/DD');
            
            
           }
           var data = {
               field : field,
               event : this.event,
               evkey : this.evkey
           }
           this.$emit('save',data);
       }
       
    },
    created()
    {
        var vm = this;
   
        
        this.hora.HH = this.event.hour.substring(0,2);
        this.hora.mm = this.event.hour.substring(3,5);
  

        this.date =  moment(this.event.date).format('MM/DD/YYYY');
        if(vm.states.length > 0){

            if (typeof vm.event.state != 'object'){
            
                vm.event.state = vm.states.find(el=>{
                    return el.name == vm.event.state
                    });
            }
        }
            
        EventBus.$on('seminarCreated',event => {
            this.seminars.push(event);
        });  
          
        
    },
  
    filters : {
            fecha(val)
            {
               return moment(val).format('DD/MM/YYYY');
            }
    }

}
</script>

<style>
    
     .small {
        width: 15%;
    }
</style>