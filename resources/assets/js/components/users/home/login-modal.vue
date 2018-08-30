<template>
    <modal name="login-modal" transition="pop-out" >
        <div class="d-flex justify-content-end align-items-center">
            <button @click="hide" class="btn btn-sm bg-white ">
                <span class="fa fa-times"></span>
            </button>
        </div>
        <div class="card text-center ml-3">
            <div class="card-body">
                <h2 class="card-title">Necesitas estar registrado para inscribirte</h2>
                <hr>
                <h4 class="card-subtitle">
                    Antes de continuar por favor 
                    <a href="/login">Ingresa</a> 
                    o 
                    <a href="/register">
                        Registrate
                    </a>  
                </h4>
                <fb-login></fb-login>
            </div>
        </div>
    </modal> 
</template>

<script>
import fbLogin from '../fblogin.vue'
export default {
    components:{fbLogin},
    methods:{
         hide () {
         this.$modal.hide('login-modal');
        }
    }
}
</script>

<style lang="scss" scoped>

    .card{
        max-width: 90vw;
    }
    h2{
        white-space: normal;
        text-align: center;
    }
</style>

