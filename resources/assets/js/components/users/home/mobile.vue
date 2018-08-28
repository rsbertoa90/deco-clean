<template>
    <div>
        <div class="row">
            <div class="col-12">
                <select v-model="selected" 
                        class="form-control">
                    <option v-for="city in activeCities" :key="city.id"
                            :value="city">
                         {{city.state.name}} - {{city.name}}
                    </option>
                </select>
            </div>
            <div class="col-12">
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
