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
         <form method="post" action="/payment/create">
             <input type="hidden" name="_token" :value="csrf">
             <input type="hidden" name="list" :value="list">
             <select class="form-control" v-model="method" name="method">
                 <option value="mercadopago">Mercadopago</option>
                 <option value="transferencia">Transferencia bancaria</option>
             </select>
             <select name="half">
                 <option value="0">Pagar Monto total</option>
                 <option value="1">Pagar Seña</option>
             </select>
             <div class="d-flex flex-column">
                <button class="btn btn-outline-success" type="submit">Pagar ahora</button>
                <span class="text-danger" v-if="method=='mercadopago'">Hay un recargo del 10% por uso del servicio Mercadopago</span>

             </div>
         </form>

        </div>
    </div>    
</template>

<script>

export default {
    props:['list'],
    data(){
        return{
            csrf : window.csrf,
            method : 'mercadopago'
        }
    },
    methods:{
         total()
        {
            var tot = 0;
            this.parsedList.forEach(i => {
                   
                    tot += i.price;
                });
          
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
