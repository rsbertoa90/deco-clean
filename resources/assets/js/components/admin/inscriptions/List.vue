<template>
    <div>
        <slot></slot>
        <hr>
        <div>
            <h4 class="text-info">  {{event.seminar.title}}  </h4>
            <h5 clasS="text-success"> <span v-if="event.mode=='online'">Online</span>
                <span v-else> {{event.state}} - {{event.city}} </span> 
            </h5>
            <h5 class="text-success"> {{event.date| date}} - {{event.hour}} </h5>
        </div>
        <table  class=" table table-striped table-bordered table-sm-responsive">
            <thead>
                <th>Fecha de inscripcion</th>
                <th>Nombre de facebook</th>
                <th>mail</th>
                <th>Precio</th>
                <th>Pagado</th>
                <th>Falta pagar</th>
            </thead>
            <tbody>
                <tr v-for="inscription in event.inscriptions" 
                           :key ="inscription.id">
                    <td> {{inscription.created_at | date}} </td>
                    <td> {{ inscription.unregistereduser.fbname }} </td>
                    <td> {{inscription.unregistereduser.email}} </td>
                    <td class="text-info"> ${{ event.price |price}} </td>
                    <td class="text-success"> ${{inscription.payd |price}} </td>
                    <td class="text-danger"> ${{event.price - inscription.payd |price}} </td>
                </tr>
            </tbody>
            <tfoot class="bg-light">
                <tr>
                    <td class="font-weight-bold">TOTALES</td>
                    <td></td>
                    <td></td>
                    <td class="text-info"> ${{event.price * event.inscriptions.length}} </td>
                    <td class="text-success"> ${{getTotalPayd(event.inscriptions)}} </td>
                    <td class="text-danger"> ${{(event.price * event.inscriptions.length) - getTotalPayd(event.inscriptions)}} </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    props : ['event'],
    data(){
        return {

        }
    },
    created(){
        console.log(this.event)
    },
    methods: {
        getTotalPayd(inscriptions)
        {
           var tot = 0;
            inscriptions.forEach(element => {
                tot+=element.payd;
            });
            return tot;
        }
    }
}
</script>
