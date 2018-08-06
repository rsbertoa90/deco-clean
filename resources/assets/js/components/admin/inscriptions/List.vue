<template>
    <div>
        <slot></slot>
        <hr>
        <div>
            <h5>  {{event.seminar.title}}  </h5>
            <h5> <span v-if="event.mode=='online'">Online</span>
                <span v-else> {{event.state}} - {{event.city}} </span> 
            </h5>
            <h5> {{event.date| date}} - {{event.hour}} </h5>
        </div>
        <table class=" table table-striped table-bordered table-sm-responsive">
            <thead>
                <th>Fecha de inscripcion</th>
                <th>Nombre de facebook</th>
                <th>mail</th>
                <th>Pagado</th>
            </thead>
            <tbody>
                <tr v-for="inscription in event.inscriptions" 
                           :key ="inscription.id">
                    <td> {{inscription.created_at | date}} </td>
                    <td> {{ inscription.unregistereduser.fbname }} </td>
                    <td> {{inscription.unregistereduser.email}} </td>
                    <td> ${{inscription.payd |price}} / ${{ event.price |price}} </td>
                </tr>
            </tbody>
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
    }
}
</script>
