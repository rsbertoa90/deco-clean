import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: null,
        activeCities:[],
        onlineEvents:[]
    },
    getters: {
        getUser(store) {
            return store.user;
        },
        
        getActiveCities(store)
        {
            return store.activeCities;
        },
        getOnlineEvents(store)
        {
            return store.onlineEvents;
        }
        
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },

        setActiveCities(state,payload){
            state.activeCities = payload;
        },

        setOnlineEvents(state,payload)
        {
            state.onlineEvents = payload;
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
            Vue.http.get('/api/activeCitys')
                .then(response => {
                    commit('setActiveCities',response.data);
                });
        },
        fetchOnlineEvents: ({commit},payload) => {
            Vue.http.get('/api/events/online')
                .then(response => {
                    commit('setOnlineEvents', response.data);
                });
        },
    },
    modules: {
    
    }

});
