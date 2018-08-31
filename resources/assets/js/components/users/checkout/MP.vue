<template>
    <div v-if="user">
        <form action="" method="post" id="pay" name="pay" >
    <fieldset>
        <ul>
            <li class="row">
                <label class="col-6 col-lg-4" for="email">Email</label>
                <input class="col-6 col-lg-8 form-control" id="email" name="email" :value="user.email" type="email" placeholder="your email"/>
            </li>
         
            <li class="row">
                <label class="col-6 col-lg-4" for="docType">Tipo de documento:</label>
                <select class="col-6 col-lg-8 form-control" id="docType" data-checkout="docType">
                    <option v-for="type in identificationTypes" :key="type"> {{type}} </option>
                </select>
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="docNumber">Numero de documento:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="docNumber" data-checkout="docNumber" placeholder="12345678" />
            </li>

            <li class="row d-flex align-items-center mt-2">
                <label class="col-6 col-lg-4" for="email">Tarjeta de credito</label>
               
               <div class="col-6 col-lg-6 row p-1 border-black d-flex justify-content-center align-items-center">
                   <div class="col-12 fieldd">
                    <label for="">Nro de tarjeta</label>
                    <input class="col-12 form-control" type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" />
                   </div>
                   <div class="col-12 fieldd">
                    <label for="">Nombre impreso en la tarjeta</label>
                    <input class="col-12 form-control" type="text" id="cardholderName" data-checkout="cardholderName" placeholder="Juan de Los Palotes" />
                   </div>
                    <div class="col-12 row">
                        <div class=" fieldd">
                            <label for=""> Mes /</label>
                            <input class=" form-control" type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" placeholder="12" /> 
                        </div>
                        <div class=" fieldd">
                            <label for=""> Año </label>
                            <input class=" form-control" type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" placeholder="2015" />
                        </div>
                        <div class="ml-2 fieldd">
                            <label for=""> cvc </label>
                            <input class="form-control" type="text" id="securityCode" data-checkout="securityCode" placeholder="123" />
                         </div>
                    </div>
                </div>
            </li>


        </ul>
        <input type="submit" value="Pay!" class="button btn-lg btn-outline-success offset-4" />
    </fieldset>
</form>
    </div>
</template>

<script>
import vueCard from 'vue-credit-card/src/components/Card.vue';
export default {
    components:{
        vueCard
    },
    computed:{
        user(){
            return this.$store.getters.getUser;
        },
        identificationTypes(){
           return  Mercadopago.getIdentificationTypes();
        }
    },
    mounted()
    {

        Mercadopago.setPublishableKey("TEST-2da260b8-d95b-4379-85f2-e52b5a8e17b9");
    }
}
</script>

<style lang="postcss" scoped>
.fieldd{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
