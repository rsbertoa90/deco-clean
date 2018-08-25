

<template>
    
    <div class="mt-4">
        <facebook-login class="button"
            appId="447979732292392"
            version="v3.1"
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
            var vm = this;
           console.log(event);
           if (event.response != undefined){

               if(event.response.status == 'connected'){
                 var tfb = event.FB;

                   console.log('fb',tfb);
                   tfb.getLoginStatus(res => {
                       console.log('status',res); 
                       var token = res.authResponse.access_token;
                       var userID = res.authResponse.userID;
                        tfb.api('/'+userID, 
                                {access_token: token,  
                                fields: 'name,email,picture'}, 
                                function(r) {
                                console.log('api',r);
                                FB.api(
                                    '/me/picture',
                                    'GET',
                                    {},
                                    function(rr) {
                                        console.log(rr);
                                    }
                                );
                            });
                            
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
