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
            <tbody>
                <tr v-for="event in events" :key="event.id">
                    <td v-if="event.mode == 'online'">
                        ONLINE
                    </td>
                    <td v-else>
                        {{event.state}} - {{event.city}}
                    </td>
                    <td>
                        {{dateDay(event.date)}} / {{dateTime(event.date)}}
                    </td>
                    <td>
                        {{event.inscriptions.length}} / {{event.quota}}
                    </td>
                    <td>
                        ${{event.price}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
export default {
    props:['seminar','events'],
    data(){
        return{

        }
    },
    methods:{
        dateDay(date){
            return moment(new Date(date)).format('D/M/Y');
        },
        dateTime(date){
            return moment(new Date(date)).format('h:mm');
        }
    }
}
</script>
