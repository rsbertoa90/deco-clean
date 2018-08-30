<template>
    <div>
        <div>
            <table class="table table-striped">
                <thead>
                    <th> - </th>
                    <th> - </th>
                </thead>
                <tbody>
                    <tr v-for="inscription in list" :key="inscription.id">
                        <td> {{inscription.seminar.title}} </td>
                        <td> {{inscription.date}} - {{inscription.hour}} </td>
                        <td> ${{inscription.price}} </td>
                    </tr>
                </tbody>
                <tfoot>
                    <td></td>
                    <td>TOTAL</td>
                    <td> {{total}} </td>
                </tfoot>
            </table>
        </div>
    </div>    
</template>

<script>
export default {
    props:['list'],
    data(){
        return{
            method : 'mercadopago'
        }
    },
    computed:{
        total()
        {
            var tot = 0;
            this.list.foreach(inscription => {
                tot += inscription.price;
            });
            return tot;
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
