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
            path:'/login',
            name:'login',
            component:require('../views/user_views/login').default,
        },
        {
            path:'/signup',
            name:'signup',
            component:require('../views/user_views/signup').default,
        },
        {
            path: '/product/:slug',
            name: 'productDetail',
            component: require('../views/product_views/product').default,
            props:true
        },
        {
            path:'/users',
            name:'users',
            component:require('../views/user_views/users').default,
        },
        {
            path:'/checkOut',
            name:'checkOut',
            component:require('../views/cart_views/cart-check-out').default,
        },
        {
            path: '*',
            component: require('../views/error_views/error_404').default,
            props:true
        }
    ],
    mode: 'history',
})

