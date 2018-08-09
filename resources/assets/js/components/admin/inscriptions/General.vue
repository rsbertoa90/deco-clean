<template>
    <div v-if="events">
        <h2>Proximos eventos:</h2>
            <div>
                 <h5> Ordenar por </h5>
                <select class="form-control" v-model="sortby">
                    <option value="seminar.title">Seminario</option>
                    <option value="city">Localidad</option>
                    <option value="date desc">Fecha</option>
                    <option value="inscriptions.length desc">Inscriptos</option>
                </select>
            </div>
            <table class="table table-bordered table-striped table-responsive-sm">
                <thead>
                    <th>seminario</th>
                    <th>Lugar</th>
                    <th>Dia y horario</th>
                    <th>Inscriptos</th>
                    <th>Precio</th>
                    <th>Recaudacion esperada</th>
                    <th>Recaudado</th>
                    <th>Falta recaudar</th>
                    <th>Detalle de inscripciones</th>
                </thead>

                <tbody>
                    <tr v-for="event in sortedEvents" :key="event.id">
                        <td class="font-weight-bold"> {{event.seminar.title}} </td>
                        <td v-if="event.mode=='online'"> ONLINE </td>
                        <td v-else> {{event.city.state.name}} - {{event.city.name}} </td>
                        <td> {{event.date | fecha}} - {{event.hour}} </td>
                        <td> {{event.inscriptions.length}} / {{event.quota}} <br>
                             <span class="text-info"> {{countIfPayd(event.inscriptions,true)}} </span> / 
                             <span class="text-danger">  {{countIfPayd(event.inscriptions,false)}} </span></td>
                        <td> ${{event.price}} </td>
                        <td class="text-center text-info"> ${{event.price * (event.inscriptions.length)}} </td>
                        <td class="text-center text-success"> ${{recaudations(event.inscriptions)}} </td>
                        <td class="text-center text-danger"> ${{(event.price * (event.inscriptions.length) - recaudations(event.inscriptions))}} </td>
                        <td >  <button v-if="event.inscriptions.length > 0" @click.prevent="inscriptionList(event)"  class="btn btn-info btn-lg">  
                                    <i class="fa fa-plus"></i> 
                            </button> 
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</template>

<script>
import {SeminarsMixin} from '../../../mixins/seminars.js';
export default {
    mixins : [SeminarsMixin],
    data(){
        return{
            events :[],
            sortby : 'seminar.title'
        }
    },
    methods : {
        countIfPayd(list,condition)
        {
            
            var filteredlist = list.filter(val => {
                if(condition){ return (val.payd > 0);}
                else return (val.payd == 0);
            });

            return filteredlist.length;
        },
        inscriptionList(event){
            this.$emit('seeList',event);
        },
        recaudations(inscriptions){
            var total = 0;
            inscriptions.forEach(ins => {
                total += ins.payd;
            });
            return total;
        }
    },
    created(){
        var vm = this;
        this.$http.get('/api/events')
            .then(response => {
                vm.events = response.data;
            });
    },
    computed : {
        sortedEvents()
        {
            return _.sortBy(this.events,this.sortby);
        }
    }
}
</script>
