<template>
    <div>
        
    </div>
</template>

<script>

export default {
    created() {
        let mp = document.createElement('script');
        mp.setAttribute('src',"https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js");
        document.head.appendChild(mp);
        },
    mounted()
    {
        Mercadopago.setPublishableKey("TEST-2da260b8-d95b-4379-85f2-e52b5a8e17b9");
    }
}
</script>
