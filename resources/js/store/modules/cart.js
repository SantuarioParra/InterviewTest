const state = {
    cartItems: []
};

const getters = {
    getAllProducts(state) {
        return state.cartItems
    },
    getProductsQuantity() {
        return state.cartItems.length;
    }
};

const mutations = {
    addProduct(state, product) {
        if (!state.cartItems.find(item => item.id === product.id)) {
            state.cartItems.push(product);
        }
    },
    deleteProduct(state, product) {
        let index = state.cartItems.indexOf(product);
        state.cartItems.splice(index, 1);
    }
};


export default {
    namespaced: true,
    state,
    getters,
    mutations
}
