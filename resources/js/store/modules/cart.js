const state = {
    cartItems:[]
};

const getters = {
    getAllProducts(state) {
        return state.cartItems
    },
    getProductsQuantity(){
      return state.cartItems.length;
    }
};

const mutations = {
    addProduct(state, product) {
        state.cartItems.push(product);
    },
    deleteProduct(state, product) {
        let index = state.cartItems.indexOf(product);
        state.cartItems.splice(index,1);
    }
};



export default {
    namespaced: true,
    state,
    getters,
    mutations
}
