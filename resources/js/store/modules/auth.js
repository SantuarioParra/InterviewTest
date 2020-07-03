import authService from '../../services/auth'

const state = {
    token: localStorage.getItem('access_token') || null,
    user: localStorage.getItem('user_info') || null,
};

const getters = {
    isLogged(state) {
        return state.token !== null;
    },
    isAdmin(state) {
        if (localStorage.getItem('user_info') === null) {
            return false;
        } else {
            let user = JSON.parse(state.user);
            if (user.roles.length !== 0) {
                return user.roles[0].name === "Administrador";
            } else {
                return false;
            }
        }

    },
    getUser(state) {
        return JSON.parse(state.user) !== null;
    }
};
const mutations = {
    updateUserInfo(state, user) {
        state.user = user;
    },
    authSuccess(state, token) {
        state.token = token;
    },
    destroyToken(state) {
        state.token = null;
        state.user = null;
    }
};

const actions = {
    saveToken(context, token) {
        context.commit('authSuccess', token)
    },
    destroyToken(context, token) {
        context.commit('destroyToken', token)
    },
    refresh(context) {
        return new Promise((resolve, reject) => {
            authService.getUser().then(response => {
                let user = response;
                context.commit('updateUserInfo', user);
                resolve(response)
            }).catch(error => {
                context.commit('destroyToken');
                reject(error);
                console.log(error.response)
            })
        })
    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
