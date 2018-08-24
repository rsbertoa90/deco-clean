

<template>
    
    <div class="mt-4">
        <facebook-login class="button"
            appId="447979732292392"
            version="v3.2"
            @login="getUserData"
            @logout="onLogout"
            @get-initial-status="getUserData"
            loginLabel="Ingresar con Faecebook"
            logoutLabel="Desloguear de Facebook">
        </facebook-login>
    </div>
</template>

<script>
import facebookLogin from 'facebook-login-vuejs';
export default {
    components : {facebookLogin},
    methods:{
        getUserData(event)
        {
           console.log(event);
           if (event.response != undefined){

               if(event.response.status == 'connected'){
                   FB = event.FB;
                   console.log('fb',FB);
                   console.log('loginstatus',FB.getLoginStatus());
               }
           }
        },
        onLogout(event){
            console.log(event);
        }
    }
}
</script>
