export const userMixin = {
    data(){
        return {
            user : null
        }
    },

    created() {
      var vm = this;
      this.$http.get('/resources/loggedUser').then(response => {
           if (response.data != null && response.data != ''){
               vm.user = response.data ; 
           }
              
       });  
    },
    computed : {
        superLogged(){
            return (this.user != null && this.user.role_id == 1);
        },
        adminLogged(){
            return (this.user != null && this.user.role_id <= 2);
        }
    },
    methods : {
        logout() {
            this.$http.get('/logout').then(response => {
                window.location.replace('/home');
            });
        }
    }
}