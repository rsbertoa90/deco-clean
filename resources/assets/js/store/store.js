import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: null,
        activeCities:[]
    },
    getters: {
        getUser(store) {
            return store.user;
        },
        
        getActiveCities(store)
        {
            return store.activeCities;
        }
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },

        setActiveCities(state,payload){
            state.activeCities = payload;
        }
    },
    actions: {
        fetchUser: ({
            commit
        }, payload) => {

            Vue.http.get('/getUser')
                .then(response => {
                    commit('setUser', response.data);

                });
        },
        fetchActiveCities: ({commit},payload) => {
            Vue.http.get('/activeCitys')
                .then(response => {
                    commit('setActiveCities',response.data);
                });
        },
    },
    modules: {
    
    }

});
