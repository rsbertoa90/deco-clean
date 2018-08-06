<template>
    <div>
        <h2>Crear evento:</h2>
        <form @submit.prevent="save">
            <!-- seminario -->
            <div class="row form-group">
                <label for="" class="col-2">Seminario</label>
                <label class="text-info font-weight-bold"> {{seminar.title}}</label>
            </div>
            <!-- MODO -->
            <div class="row form-group">
                <label for="" class="col-2">Modalidad</label>
                <select required v-model="newEvent.mode" class="col-4 form-control">
                    <option value="online">online</option>
                    <option value="presencial">presencial</option>
                </select>
            </div>
            <!-- Provincia y ciudad -->
            <div v-if="newEvent.mode == 'presencial'">

                <div class="row form-group">
                    <label for="" class="col-2">Provincia</label>
                    <select v-model="state" type="text" class="col-4 form-control">
                        <option v-for="state in states" :key="state.id" 
                                :value="state"> {{state.name}} </option>
                    </select>
                </div>
                <div v-if="state" class="row form-group">
                    <label for="" class="col-2"> Ciudad </label>
                    <select v-model="city" type="text" class="col-4 form-control">
                        <option v-for="city in state.cities"
                                :key="city.id" :value="city"> {{city.name}} </option>
                    </select>
                </div>
            </div>
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
                <button type="submit" class="btn btn-lg btn-outline-success">Guardar</button>
            </div>
        </form>
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
import {citiesMixin} from '../../../mixins/cities.js'
import {SeminarsMixin} from '../../../mixins/seminars.js'
export default {
    props :['seminar'],
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
                
                mode: 'presencial',
            },
            city: '',
            state: '',
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
            this.city= '';
            this.state= '';
        },
        save(){
            var vm = this;
            this.newEvent.hour = `${this.hora.HH}:${this.hora.mm}`;
            // console.log(this.newEvent.date);
            if (this.newEvent.mode == 'presencial')
            {
                
                this.newEvent.city = this.city.name;
                this.newEvent.state = this.state.name;
            }
                this.newEvent.seminar_id = this.seminar.id;
                this.$http.post('/admin/event',this.newEvent)
                .then(response => {
                    var newev = response.data
                    vm.$emit('eventCreated',response.data);
                    this.reset();
                });
        }
    }
}
</script>
