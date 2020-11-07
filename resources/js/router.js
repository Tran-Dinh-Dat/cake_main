import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/templates/admin/Home.vue';
import Category from './components/templates/admin/Category.vue';

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'admin.home',
        component: Home
    },
    {
        path: '/admin/categories',
        name: 'admin.categories',
        component: Category
    },
];

const router = new Router({
    routes: routes,
});

export default router;
