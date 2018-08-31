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
                <label class="col-6 col-lg-4" for="cardNumber">Credit card number:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" />
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="securityCode">Security code:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="securityCode" data-checkout="securityCode" placeholder="123" />
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="cardExpirationMonth">Expiration month:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" placeholder="12" />
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="cardExpirationYear">Expiration year:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" placeholder="2015" />
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="cardholderName">Card holder name:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="cardholderName" data-checkout="cardholderName" placeholder="APRO" />
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="docType">Document type:</label>
                <select class="col-6 col-lg-8 form-control" id="docType" data-checkout="docType">
                    <option v-for="type in identificationTypes" :key="type"> {{type}} </option>
                </select>
            </li>
            <li class="row">
                <label class="col-6 col-lg-4" for="docNumber">Document number:</label>
                <input class="col-6 col-lg-8 form-control" type="text" id="docNumber" data-checkout="docNumber" placeholder="12345678" />
            </li>
        </ul>
        <input type="submit" value="Pay!" class="button btn-lg btn-outline-success offset-4" />
    </fieldset>
</form>
    </div>
</template>

<script>

export default {
    computed:{
        user(){
            return this.$store.getters.getUser;
        },
        identificationTypes(){
            Mercadopago.getIdentificationTypes(res => {
                console.log(res);
                return res;
            });
        }
    },
    mounted()
    {

        Mercadopago.setPublishableKey("TEST-2da260b8-d95b-4379-85f2-e52b5a8e17b9");
    }
}
</script>
