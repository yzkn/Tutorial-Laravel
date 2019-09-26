const state = {
    authenticated: false
};

const mutations = {
    logedin (state) {
        state.authenticated = true;
    },
    logedout (state) {
        state.authenticated = false;
    }
};

const getters = {
    isLogin (state) {
        return state.authenticated;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    getters
};