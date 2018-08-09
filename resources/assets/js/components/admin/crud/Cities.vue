<template>
    <div>
            <div class="row d-flex flex-column">
                 <button  class="btn-block btn-outline-info"
                  @click="online" > ONLINE </button>

                <button v-for="city in cities" :key="city.id"
                       class="btn-block btn-outline-info" @click="select(city)" >
                     {{location(city)}}
                </button>

                <button  class="btn-block btn-outline-info"
                @click="newCity = true" > Otra </button>

                <div v-if="newCity">
                    <select v-model="newState" class="form-control">
                        <option v-for="state in states"
                                :key="state.id"
                                :value="state">
                            {{ state.name }}
                        </option>
                    </select>
                    <select v-if="newState" v-model="newCity" class="form-control">
                        <option v-for="city in newState.cities"
                                :key="city.id"
                                :value="city">
                            {{ city.name }}
                        </option>
                    </select>
                </div>
            </div>
    
    </div>
</template>
<script>
import { EventBus } from '../../../app.js';
export default {
    data(){
        return {
            cities : [],
            newCity : false,
            states : null,
            newState : null,
        }
    },
    created(){
        var vm = this;
        this.$http.get('/api/active-cities')
            .then(response => {
                vm.cities = response.data;
            });

        EventBus.$on('eventCreated',(event)=>{
            let cityId = event.city_id;
            let exists = vm.cities.find(c=>{
                return c.id == cityId;
            });

            if (!exists) {
                vm.$http.get('/api/active-cities')
                    .then(response => {
                     vm.cities = response.data;
                     
                    });
            }
        });
    },
    methods : {
         
         location(city){
           return `${city.state.name} - ${city.name}`;
       },
       online(){
           this.$emit('online');
           this.newCity= false;
       },
       select(city)
       {
           this.newCity = false;
           this.$emit('citySelected',city);
       }
    },
    watch : {
        newCity(){
            var vm = this;
            if (!this.states){
                vm.$http.get('/api/states')
                    .then(response => {
                        vm.states = response.data;
                    });
            }
            else if (typeof vm.newCity == 'object')
            {
                this.$emit('citySelected',vm.newCity);
            }
        }
    }

}
</script>
