

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
                   tfb = event.FB;
                   console.log('fb',tfb);
                   console.log('status',tfb.getLoginStatus(res => {
                       console.log(res);
                   }));
                  tfb.api('/me', {fields: 'last_name'}, function(r) {
                    console.log(r);
                });
                  
               }
           }
        },
        onLogout(event){
            console.log(event);
        }
    }
}
</script>
