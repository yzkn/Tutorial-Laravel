import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store/index';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: require('./components/pages/Home.vue').default, name: 'home' },
    { path: '/login', component: require('./components/pages/Login.vue').default, name: 'login' },
    { path: '/user', component: require('./components/pages/User.vue').default, meta: { requiresAuth: true }, name: 'user-read' },
    { path: '/item', component: require('./components/pages/ItemReadAll.vue').default, meta: { requiresAuth: true }, name: 'item-readall' },
    { path: '/item/create', component: require('./components/pages/ItemCreate.vue').default, meta: { requiresAuth: true }, name: 'item-create' },
    { path: '/item/:id', component: require('./components/pages/ItemRead.vue').default, meta: { requiresAuth: true }, name: 'item-read' },
    { path: '/subitem', component: require('./components/pages/SubItemReadAll.vue').default, meta: { requiresAuth: true }, name: 'subitem-readall' },
    { path: '/subitem/create', component: require('./components/pages/SubItemCreate.vue').default, meta: { requiresAuth: true }, name: 'subitem-create' },
    { path: '/subitem/:id', component: require('./components/pages/SubItemRead.vue').default, meta: { requiresAuth: true }, name: 'subitem-read' },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters['auth/isLogin'] === false) {
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