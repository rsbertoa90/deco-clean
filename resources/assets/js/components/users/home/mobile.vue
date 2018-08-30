<template>
    <div class="">
        <div class="row">
            <div class="col-12"> 
                <select class="form-control" v-model="selected">
                    <option  @click="mode='online'" value="null">
                         ONLINE
                    </option>
                    <option v-for="city in activeCities" :key="city.id"
                            :value="city">
                         {{city.state.name}} - {{city.name}}
                    </option>
                </select>  
            </div>
            <div class="col-12" v-if="events">
                <h1>Inscribite en nuestros seminarios</h1>
                <hr>
                        <div class="card text-center mt-3" v-for="event in events" :key="event.id">
                             <div class="card-body">
                                <h5 class="card-title"> {{event.seminar.title}} </h5>
                                <div class="card-subtitle"> 
                                    {{event.date | date}} 
                                    {{event.hour}} 
                                </div>
                                <div class="card-subtitle text-success font-weight-bold"> ${{event.price}} </div>
                                <div class="card-text text-danger"  v-if="event.inscriptions.length >= event.quota"> Completo! </div>
                                <div class="card-text text-warning"> Quedan {{event.quota - event.inscriptions.length}} lugares! </div>
                            
                                <div v-if="!event.userInscription"> <button :disabled="event.inscriptions.length >= event.quota" @click="inscription(event)" class="btn btn-block btn-outline-success">Inscribirme</button> </div>
                                <div v-else> <button :disabled="event.inscriptions.length >= event.quota" @click="inscription(event)" class="btn btn-block btn-outline-danger"> Cancelar inscripcion </button> </div>
                             </div>
                        </div>
            </div>
        </div>
        <login-modal></login-modal>

        <div class="m-bottom" v-if="events && inscriptions && inscriptions.length > 0"></div>
        <div v-if="events && inscriptions && inscriptions.length > 0" class="pay-pop bg-success p-2">
            <div class="bg-white">
                <span class="fa fa-shopping-cart text-success"></span>
                <h4 v-if="inscriptions.length == 1">Tienes {{inscriptions.length}} inscripcion pendientes </h4>
                <h4 v-if="inscriptions.length > 1">Tienes {{inscriptions.length}} inscripciones pendientes </h4>
                <form action="/checkout" method="post">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="list" :value="jsonList">
                    <button type="submit" class="btn-block btn-outline-success">
                        Pagar ahora
                    </button>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    import loginModal from './login-modal.vue';
export default {
    components:{loginModal},
    data(){
        return{
            csrf : window.csrf,
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
                    Vue.set(event,'userInscription',true);
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
        },
        inscriptions(){
            if(this.user){
                var vm = this;
                return this.events.filter(ev => {
                    let oldinscription = vm.user.inscriptions.find(e => {
                        return e.id == ev.id;
                    });
                    if (!oldinscription){
                        return ev.userInscription;
                    }  
                });
            }
        },
        jsonList(){
            return JSON.stringify(this.inscriptions);
        }
    },
    watch :{
        selected(){
            if (this.selected != null){
                this.mode = 'presencial';
            }
        },
        mode(){
            if (this.mode == 'online'){
                this.selected = null;
            }
        },
        user(){
            if(this.user){

                var vm = this;
                vm.user.inscriptions.forEach(insc => {
                let event = vm.events.find(e => {
                    return (e.id == insc.event.id && insc.status != 'cancelada')
                    });
                if (event)
                {
                     Vue.set(event,'userInscription',true);
                }
            });
            }
        }
    },
    
}
</script>

<style lang="scss" scoped>
    h1{
        font-size: 30px;
    }
    .pay-pop{
        position: fixed;
        bottom: 2%;
        right: 2%;
        .bg-white{
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 10px;
        }
        
    }
    .fa-shopping-cart{
        font-size: 30px;
        margin-bottom: 10px;
    }

    .m-bottom{
        margin-bottom:200px;
    }

</style>

