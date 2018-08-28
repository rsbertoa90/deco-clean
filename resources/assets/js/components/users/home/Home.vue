<template>
    <div>
        <home-mobile v-if="$mq != 'lg'"></home-mobile>
        <home-web v-else></home-web>
    </div>
</template>

<script>
import homeMobile from './mobile.vue'
import homeWeb from './web.vue'
export default {
    components:{
        homeMobile,
        homeWeb
    }
}
</script>
