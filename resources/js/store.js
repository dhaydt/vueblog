import Vue from 'vue'
import vuex from 'vuex'

Vue.use(vuex);

export default new vuex.Store({
    state : {
        counter: 1000,
        deleteModalObj : {
            showDeleteModal : false,
            deleteUrl : '',
            data : null
        }
    },

    getters : {
        getCounter(state){
            return state.counter
        },
        getDeleteModalObj(state){
            return state.deleteModalObj
        },

    },

    mutations : {
        changeTheCounter(state, data) {
            state.counter += data
        }
    },

    actions : {
        changeCounterAction({commit}, data){
            commit('changeTheCounter', data)
        }
    }

});