

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
            if(event.status == 'connected')
            {
                console.log('conected');
            }
            else {
               
                if(event.status != 'unknown'){
                    if (event.response.status == 'connected'){
                        console.log('ptm1',event);
                        console.log('ptm2',event.response);
                        console.log('ptm3',event.response.authResponse);
                        console.log('ptm3',event.response.authResponse.userID);
                        let userID = event.response.authResponse.userID;
                        let token = event.response.authResponse.accessToken;
                        this.$http.get('https://graph.facebook.com/'+userID+'access_token='+token)
                            .then(response => {
                                console.log(response);
                            });
                        FB.api(
                           `/${userID}/`,
                            function (response) {
                                if (response && !response.error) {
                                console.log(response);
                                }else{
                                    console.log(response);
                                }
                            }
                        );
                    }
                }
            }
        },
        onLogout(event){
            console.log(event);
        }
    }
}
</script>
