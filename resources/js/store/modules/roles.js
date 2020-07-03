const state={
    roles:[]
};

const getters={
    getTotalRoles(state){
        return state.roles.length;
    },
    getAllRoles(state){
        return state.roles;
    }
};

const mutations={
    updateRoles(state,roles){
        state.roles = roles;
    }
};

const actions={
    updateRoles(context,roles){
        context.commit('updateRoles',roles);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
