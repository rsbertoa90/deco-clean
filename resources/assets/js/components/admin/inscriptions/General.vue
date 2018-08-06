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
                    <th>Recaudacion</th>
                </thead>

                <tbody>
                    <tr v-for="event in sortedEvents" :key="event.id">
                        <td class="font-weight-bold"> {{event.seminar.title}} </td>
                        <td v-if="event.mode=='online'"> ONLINE </td>
                        <td v-else> {{event.state}} - {{event.city}} </td>
                        <td> {{event.date | fecha}} - {{event.hour}} </td>
                        <td> {{event.inscriptions.length}} / {{event.quota}} </td>
                        <td> ${{event.price}} </td>
                        <td> ${{recaudations(event.inscriptions)}} </td>
                        <td>  <button @click.prevent="inscriptionList(event)"  class="btn btn-outline-info btn-lg">  
                                    <i class="fa fa-search"></i> 
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
