import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            name: 'home',
            component: require('../views/Home').default,
        },
        {
            path:'*',
            component:require('../views/error_views/error_404').default,
        }
    ],
    mode:'history'
})
