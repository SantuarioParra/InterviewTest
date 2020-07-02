import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);
import products from './modules/products';
import cart from './modules/cart';
import auth from './modules/auth'

/*const debug = process.env.NODE_ENV !== 'production';*/

export default new Vuex.Store({
    modules: {
        products,
        cart,
        auth
    },
    /*strict: debug,*/
})

