<template>
    <div>
        <div class="row">
            <div class="col-4">   
                    <button v-for="city in activeCities" :key="city.id"
                            :value="city" class="btn btn-block btn-outline-info">
                         {{city.state.name}} - {{city.name}}
                    </button>
            </div>
            <div class="col-8">
                TABLA DE EVENTOS
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            selected: null
        }
    },
    computed:{
        activeCities(){
            this.$store.getters.getActiveCities;
        }
    }
}
</script>
