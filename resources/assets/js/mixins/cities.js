export const citiesMixin = {
    data(){
        return {
            states : [],
            cities : [],
          
        }
    },
    methods : {
       location(city){
           return `${city.state.name} - ${city.name}`;
       }
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