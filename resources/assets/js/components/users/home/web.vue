<template>
    <div>
        <div class="row">
            <div class="col-3">   
                    <button  @click="mode='online'" class="btn btn-block"
                     :class="{'btn-info' : mode=='online', 'btn-outline-info': mode != 'online'}">
                         ONLINE
                    </button>
                    <button v-for="city in activeCities" :key="city.id"
                            @click="setCity(city)" class="btn btn-block"
                            :class="{'btn-info' : selected==city, 'btn-outline-info': selected != city}">
                         {{city.state.name}} - {{city.name}}
                    </button>
            </div>
            <div class="col-9" v-if="events">
                <h1>Inscribite en nuestros seminarios</h1>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>Seminario</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Precio</th>
                        <th>Cupo</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="event in events" :key="event.id">
                            <td> {{event.seminar.title}} </td>
                            <td> {{event.date | date}} </td>
                            <td> {{event.hour}} </td>
                            <td> ${{event.price}} </td>
                            <td v-if="event.inscriptions.length >= event.quota" class="text-danger"> Completo! </td>
                            <td v-else class="text-warning"> Quedan {{event.quota - event.inscriptions.length}} lugares! </td>
                            <td v-if="event.userInscription"> <button @click="inscription(event)" class="btn btn-block btn-outline-success">Inscribirme</button> </td>
                            <td v-else> <button @click="inscription(event)" class="btn btn-block btn-outline-danger"> Cancelar inscripcion </button> </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <login-modal></login-modal>
    </div>
</template>

<script>
    import loginModal from './login-modal.vue';
export default {
    components:{loginModal},
    data(){
        return{
            selected: null,
            mode : 'online',
    
        }
    },
    methods:{ 
        inscription(event){
            console.log(this.user);
            if(!this.user)
            {
                this.$modal.show('login-modal');
            } else {
                if(event.userInscription == undefined)
                {
                    vue.set(event,'userInscription',true);
                }else{
                    event.userInscription = !event.userInscription;
                }
            }
        },
        setCity(city){
            this.mode="presencial";
            this.selected = city; 
        }
    },
    computed:{
        user(){
            return this.$store.getters.getUser;
        },
        activeCities(){
            return this.$store.getters.getActiveCities;
        },
        onlineEvents(){
            return this.$store.getters.getOnlineEvents;
        },
        events(){
            if (this.mode == 'online')
            {
                return this.onlineEvents;
            }
            else {
                return this.selected.events;
            }
        }
    },
    watch :{
        mode(){
            if (this.mode == 'online'){
                this.selected = null;
            }
        }
    }
}
</script>
