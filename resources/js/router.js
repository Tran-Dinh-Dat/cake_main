import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/templates/admin/Home.vue';
import Dashboard from './components/templates/admin/Dashboard.vue';
import Category from './components/templates/admin/Category.vue';
import Register from './components/templates/auth/Register.vue';
import Login from './components/templates/auth/Login.vue';
import ResetPassword from './components/templates/auth/ResetPassword.vue';
import * as authService from './services/auth_service.js';

Vue.use(VueRouter);

const routes = [
    {
        path: '/admin',
        name: 'admin',
        component: Home,
        children:  [
            {
                path: '/',
                name: 'admin.dashboard',
                component: Dashboard
            },
            {
                path: '/admin/categories',
                name: 'admin.categories',
                component: Category
            }
        ],
        beforeEnter(to, from, next) {
            if (!authService.isLoggedIn()) {
                next('/login');
            } else {
                next();
            }
        }
    },
    
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter(to, from, next) {
            if (!authService.isLoggedIn()) {
                next();
            } else {
                next('/admin');
            }
        }
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ResetPassword
    }
];

const router = new VueRouter({
    routes: routes,
    // mode: 'history',
    linkActiveClass: 'active'
});

export default router;