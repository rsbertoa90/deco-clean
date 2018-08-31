<template>
    <div>
        <div>
            <h1>Inscripciones</h1>
            <table class="table table-striped">
                <thead>
                    <th> - </th>
                    <th> - </th>
                </thead>
              
                <tbody>
                    <tr v-for="inscription in parsedList" :key="inscription.id">
                        <td> {{inscription.seminar.title}} </td>
                        <td> {{inscription.date | date}} - {{inscription.hour}} </td>
                        <td> ${{inscription.price}} </td>
                    </tr>
                </tbody>
                <tfoot>
                    <td></td>
                    <td>TOTAL</td>
                    <td> ${{total()}} </td>
                </tfoot>
            </table>
            <checkout-mp></checkout-mp>
        </div>
    </div>    
</template>

<script>
import checkoutMp from './MP.vue';
export default {
    props:['list'],
    components:{checkoutMp},
    data(){
        return{
            method : 'mercadopago'
        }
    },
    methods:{
         total()
        {
            var tot = 0;
            this.parsedList.forEach(i => {
                    console.log(i);
                    tot += i.price;
                });
            console.log('tot',tot);
            return tot;
        }
    },
    computed:{
        parsedList(){
            var vm=this;
            var res = [];
            if (this.list){
                var parsed = JSON.parse(this.list);
                parsed.forEach(id => {
                    vm.$http.get('/api/event/'+id)
                        .then(response => {
                            res.push(response.data);
                            vm.$forceUpdate();
                        });
                });
            }
            return res;
        },
       
    }
}
</script>

<style lang="scss" scoped>

</style>
