import axiosRequest from '../../services/axios_config'
import AuthService from '../../services/auth'

const state = {
    token: localStorage.getItem('access_token') || null,
    user: {}
};

const getters = {
    isLogged(state) {
        return state.token !== null;
    },
};
const mutations = {

    authSuccess(state, token) {
        state.token = token;
    },
    destroyToken(state) {
        state.token = null;
        state.user = {}
    }
};

const actions = {
    saveToken(context, token) {
        context.commit('authSuccess', token)
    },
    destroyToken(context, token) {
        context.commit('destroyToken', token)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
