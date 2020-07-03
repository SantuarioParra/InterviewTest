const state = {
    cartItems: []
};

const getters = {
    getAllProducts(state) {
        return state.cartItems
    },
    getProductsQuantity() {
        return state.cartItems.length;
    },
    productsTotalPrice(state) {
        let total = 0;
        state.cartItems.forEach(product => {
            total += product.price*product.quantity;
        });
        return total.toFixed(2);
    }
};

const mutations = {
    addProduct(state, product) {
        if (!state.cartItems.find(item => item.id === product.id)) {
            state.cartItems.push(product);
        } else {
            state.cartItems = [
                ...state.cartItems.filter(item => item.id !== product.id),
                product
            ];
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
