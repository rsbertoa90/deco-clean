<template>
    <div>
        <div v-for="seminar in seminars" :key="seminar.id">
            <hr class="mt-3">
            <h3> {{seminar.title}} </h3>
            <h5>Proximos eventos:</h5>
            <table class="table table-bordered table-striped table-responsive-sm">
                <thead>
                    <th>Lugar</th>
                    <th>Dia y horario</th>
                    <th>Inscriptos</th>
                    <th>Precio</th>
                    <th>Recaudacion</th>
                </thead>

                <tbody>
                    <tr v-for="event in futureEvents(seminar)" :key="event.id">
                        <td v-if="event.mode=='online'"> ONLINE </td>
                        <td v-else> {{event.state}} - {{event.city}} </td>
                        <td> {{event.date | fecha}} - {{event.hour}} </td>
                        <td> {{event.inscriptions.length}} / {{event.quota}} </td>
                        <td> ${{event.price}} </td>
                        <td> ${{recaudations(event.inscriptions)}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import {SeminarsMixin} from '../../mixins/seminars.js';
export default {
    mixins : [SeminarsMixin],
    data(){
        return{
        
        }
    },
    methods : {
        recaudations(inscriptions){
            var total = 0;
            inscriptions.forEach(ins => {
                total += ins.payd;
            });
            return total;
        }
    }
}
</script>
