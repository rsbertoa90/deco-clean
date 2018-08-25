

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

    <div v-if="loading" class="load-overlay">
        <pulse-loader :loading="loading" size="300px"></pulse-loader>
    </div>

    </div>
</template>

<script>
import facebookLogin from 'facebook-login-vuejs';
export default {
    components : {facebookLogin},
    data(){return{
        loading:false
    }},
    methods:{
        getUserData(event)
        {
            var vm = this;
           console.log(event);
           if (event.response != undefined){

               if(event.response.status == 'connected'){
                 var tfb = event.FB;

                   //console.log('fb',tfb);
                  
                   tfb.getLoginStatus(res => {
                       //console.log('status',res); 
                       var token = res.authResponse.access_token;
                       var userID = res.authResponse.userID;
                        vm.loading=true;
                        tfb.api('/'+userID, 
                                {access_token: token,  
                                fields: 'name,email,picture'}, 
                                function(r) {
                               // console.log('r',r);
                                var data = {
                                    name : r.name,
                                    email : r.email,
                                    provider_id : userID,
                                    avatar : r.picture.data.url
                                }
                                //console.log('data',data);
                                vm.$http.post('fblogin',data)
                                    .then(ress => {
                                        
                                        window.location.replace('/');
                                    });
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

<style scoped>
    .load-overlay{
        position: absolute;
        top: 0;
        left:0;
        width: 100vw;
        height: 100vh;
        color: #aaaaaa55;
    }
</style>
