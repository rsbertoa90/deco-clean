<template>
    <div>
        <div>
            <h1>ASDF</h1>
            <table class="table table-striped">
                <thead>
                    <th> - </th>
                    <th> - </th>
                </thead>
                <tbody>
                    <tr v-for="inscription in parsedList" :key="inscription.id">
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
        parsedList(){
            var vm=this;
            var res = [];
            if (this.list){
                console.log(this.list);
                var parsed = JSON.parse(this.list);
                console.log(parsed);
                parsed.forEach(id => {
                    vm.$http.get('/api/event/'+id)
                        .then(response => {
                            res.push(response.data);
                        });
                });
            }
            return res;
        },
        total()
        {
            var tot = 0;
            if(this.parsedList){
                this.parsedList.forEach(inscription => {
                    tot += inscription.price;
                });
            }
            return tot;
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
