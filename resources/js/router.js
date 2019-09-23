import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/pages/Home'
import Login from './components/pages/Login'
import User from './components/pages/User'
import Item from './components/pages/Item'
import SubItem from './components/pages/SubItem'

Vue.use(VueRouter);

const routes = [
    { path: '/', component: require('./components/pages/Home.vue').default },
    { path: '/login', component: require('./components/pages/Login.vue').default },
    { path: '/user', component: require('./components/pages/User.vue').default, meta: { requiresAuth: true } },
    { path: '/item', component: require('./components/pages/Item.vue').default, meta: { requiresAuth: true } },
    { path: '/subitem', component: require('./components/pages/SubItem.vue').default, meta: { requiresAuth: true } },

    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/user', component: User, meta: { requiresAuth: true } },
    { path: '/item', component: Item, meta: { requiresAuth: true } },
    { path: '/subitem', component: SubItem, meta: { requiresAuth: true } }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (state.isLogin === false) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next();
    }
});

export default router;