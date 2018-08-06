<template>
    <tr>
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
                                <select  class="form-control" 
                                          v-if="event.state != null"  
                                          v-model="event.city" 
                                          @change="saveCity()">
                                    <option  v-for="city in event.state.cities" :key="city.id"
                                            :value="city.name"> {{city.name}} </option>
                                </select>
                            </div>
                        </div>
                    </td>
                    <td>
                        
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
                    <td>
                        <input v-model.lazy="event.quota" @change="save('quota')" 
                               type="number" min="0" class="form-control">
                    </td>
                    <td>
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
export default {
    props :['event','evkey','states'],
    watch : {
        states(){
            // console.log('asd');
            var vm = this;
            // console.log('en carga estados',vm.event.state);

            vm.event.state = vm.states.find(el=>{
                    return el.name == vm.event.state
                    });
            // console.log(vm.event.state);
            
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
          saveCity(){
              var vm = this;
            var data = {
                id  : vm.event.id,
                state : vm.event.state.name,
                city : vm.event.city,
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

       save(field){
           if (this.event.id == null){return;}
           if (field == 'hour')
           {
               this.event.hour = `${this.hora.HH}:${this.hora.mm}`;
           } else if (field == 'date')
           {
            //    console.log(this.event.date);
               this.event.date = moment(this.date).format('YYYY/MM/DD');
            //    console.log(this.date,this.event.date);
            
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
        // console.log(this.hora);

        this.date =  moment(this.event.date).format('MM/DD/YYYY');
        // console.log (this.event.date);
        // console.log(this.date);
        // console.log(vm.states);
        if(vm.states.length > 0){

            if (typeof vm.event.state != 'object'){
                //  console.log('en created',vm.event.state);
                vm.event.state = vm.states.find(el=>{
                    return el.name == vm.event.state
                    });
            }
        }
            
                
          
        
    },
  
    filters : {
            fecha(val)
            {
               return moment(val).format('DD/MM/YYYY');
            }
    }

}
</script>
