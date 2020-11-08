import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/templates/admin/Home.vue';
import Dashboard from './components/templates/admin/Dashboard.vue';
import Category from './components/templates/admin/Category.vue';
import Register from './components/templates/auth/Register.vue';
import Login from './components/templates/auth/Login.vue';
import ResetPassword from './components/templates/auth/ResetPassword.vue';

Vue.use(Router);

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
        ]
    },
    
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ResetPassword
    }
];

const router = new Router({
    routes: routes,
});

export default router;
