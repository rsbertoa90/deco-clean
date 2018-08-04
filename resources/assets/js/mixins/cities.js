export const citiesMixin = {
    data(){
        return {
            states : [],
            cities : [],
          
        }
    },
    methods : {
       
    },

    created(){
        var vm = this;
       
        this.$http.get('/api/states')
            .then(response  => {
                vm.states = response.data;
                // console.log(response.data);
                
            });
    },
 
}