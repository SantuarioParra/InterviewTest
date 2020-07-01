import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            component: require('../views/product_views/index').default,
        },
        {
            path: '/product/:slug',
            name: 'productDetail',
            component: require('../views/product_views/product').default,
            props:true
        },
        {
            path: '*',
            component: require('../views/error_views/error_404').default,
            props:true
        }
    ],
    mode: 'history'
})
