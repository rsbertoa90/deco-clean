<template>
    <modal name="login-modal" transition="pop-out" >
        <div class="d-flex justify-content-end">
            <button @click="hide" class="btn btn-sm bg-white ">
                <span class="fa fa-times"></span>
            </button>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center">
            <h2>Necesitas estar registrado para inscribirte</h2>
            <hr>
            <h4>
                Antes de continuar por favor 
                <a href="/login">Ingresa</a> 
                o 
                <a href="/register">
                    Registrate
                </a>  
            </h4>
            <fb-login></fb-login>
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
