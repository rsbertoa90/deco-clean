<template>
    <div>
        <h2>Crear evento:</h2>
        <form @submit.prevent="save">
            <!-- seminario -->
                <div class="row form-group">
                <label for="" class="col-2">Seminario</label>
                <select required v-model="newEvent.seminar" class="col-4 form-control">
                    <option v-for="seminar in seminars"
                            :key="seminar.id"
                            :value="seminar">
                            {{seminar.title}}
                    </option>
                </select>

          
            </div>


         
            <!-- Provincia y ciudad -->
          
            <!-- fecha y hora -->
            <div class="row form-group">
                <label for="" class="col-2">Fecha y hora</label>

                    <date-picker class="ml-1 col-11 col-lg-2" 
                                 format='dd/MM/yyyy' 
                                 v-model="newEvent.date"
                                 :disabledDates="disabledDates"> 
                    </date-picker>

                    <time-picker class="ml-1 col-11 col-lg-4" 
                         v-model="hora" 
                         format="HH:mm"
                         :minute-interval="15">
                    </time-picker>
            </div>
            <div class="row form-group">
                <label for="" class="col-2">Precio</label>
                $ <input required v-model="newEvent.price" 
                        type="number" min="0">
            </div>
            <div class="row form-group">
                <label for="" class="col-2">Cupo</label>
                 <input required v-model="newEvent.quota" 
                        type="number" min="0">
            </div>
            <div class="row form-group">
                <button type="submit" class="btn btn-lg btn-outline-success offset-2">Guardar</button>
            </div>
        </form>
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
import {citiesMixin} from '../../../mixins/cities.js'
import {SeminarsMixin} from '../../../mixins/seminars.js'
export default {
    props :['city','mode'],
    mixins :[citiesMixin,SeminarsMixin],
    data(){
        
        return {

            disabledDates : {
                to :new Date()
            },
             hora:{
                HH : '',
                mm : ''
            },
            
            newEvent : {
                price : '',
                quota : '',
                date: null,
                hour: {},
                seminar:null,
            },

            newSeminar : {
                title : '',
                description : ''
            }
        }
    },
    // mounted(){
    //     $(".datepicker").datepicker({
    //     dateFormat: "dd-mm-yy"
    // });
    // $('.timepicker').timepicker();
    // },
    methods : {
        reset(){
             this.newEvent = {
                price : '',
                quota : '',
                date: null,
                hour: null,
                
                mode: 'presencial',
            };
            this.hora = { 
                HH : '',
                mm : ''};
         
       
        },
        save(){
            var vm = this;
            this.newEvent.hour = `${this.hora.HH}:${this.hora.mm}`;
            this.newEvent.date = moment(this.newEvent.date).format('YYYY-MM-DD');
           
           
                this.newEvent.seminar_id = this.newEvent.seminar.id;
                this.newEvent.mode = this.mode;
                if (this.mode == 'presencial'){
                    this.newEvent.city_id = this.city.id;
                }
       
                this.$http.post('/admin/event',this.newEvent)
                .then(response => {
                    var newev = response.data
                   
                    EventBus.$emit('eventCreated',response.data);
                    this.reset();
                });
        },
       
        },
         created(){
             EventBus.$on('seminarCreated',event => {
                this.seminars.push(event);
                
        }); 
    }
}
</script>

<style scoped>
   
</style>