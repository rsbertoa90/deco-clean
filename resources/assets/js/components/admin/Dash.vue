<template>
<div>

    <insc-general v-if="component=='insc-general'" @seeList="seeList">
       
    </insc-general>

    <insc-list v-if="component=='insc-list'" :event="event">
         <button class="btn-sm btn-outline-info" 
                @click="component = 'insc-general'">Atras</button>
     </insc-list>
</div>
</template>

<script>
import inscGeneral from './inscriptions/General.vue';
import inscList from './inscriptions/List.vue';

export default {
    components :{inscGeneral,inscList},
    data(){
        return{
            component : 'insc-general',
            event : null
        }
    },
    methods : {
        seeList(event){
            this.component='insc-list';
            this.event = event;
        }
    }
}
</script>
