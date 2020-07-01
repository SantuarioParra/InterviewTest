import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);
import products from './modules/products';
import cart from './modules/cart';
import {createModule} from'vuex-toast';

/*const debug = process.env.NODE_ENV !== 'production';*/

export default new Vuex.Store({
    modules: {
        products,
        cart,
    },
    /*strict: debug,*/
})

