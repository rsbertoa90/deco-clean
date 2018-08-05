import { isMoment } from "moment";

export const SeminarsMixin = {
    data(){
        return {
            seminars : null
        }
    },
    created(){
        var vm = this;
        this.$http.get('/api/seminars').then(response =>{
            vm.seminars = response.data;
        });
    },
    methods: {
        futureEvents(seminar){
             var events = seminar.events;
             var res = events.filter(function (el) {
                //  console.log(new Date(el.date), Date.now());
                 return (new Date(el.date)) >= Date.now();
             });
          
             return res;

        },
        pastEvents(seminar){
             var events = seminar.events;
             return events.filter(function (el) {
                 return  el.date <= Date.now()  ;
             });
        }
    },
    filters: {
        fecha(val) {
            return moment(val).format('DD/MM/YYYY');
        }
    },
}