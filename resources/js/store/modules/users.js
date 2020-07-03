const state={
    users:[]
};

const getters={
  getTotalUsers(state){
      return state.users.length;
  },
  getAllData(state){
      return state.users;
  }
};

const mutations={
    updateUsers(state,users){
        state.users = users;
    }
};

const actions={
  updateUsers(context,users){
      context.commit('updateUsers',users);
  }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
