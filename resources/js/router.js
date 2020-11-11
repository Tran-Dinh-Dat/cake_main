import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/templates/admin/Home.vue';
import Dashboard from './components/templates/admin/Dashboard.vue';
import Category from './components/templates/admin/Category.vue';
import Product from './components/templates/admin/Product.vue';
import Register from './components/templates/auth/Register.vue';
import Login from './components/templates/auth/Login.vue';
import ResetPasswordRequest from './components/templates/auth/ResetPasswordRequest.vue';
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
                component: Category,
                beforeEnter(to, from, next) {
                    if (authService.getUserRole() == 'administrator') {
                        next();
                    } else {
                        next('/404');
                    }
                }
            },
            {
                path: '/admin/products',
                name: 'admin.products',
                component: Product,
                beforeEnter(to, from, next) {
                    if (authService.getUserRole() == 'user') {
                        next();
                    } else {
                        next('/404');
                    }
                }
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
        path: '/reset-password-request',
        name: 'reset-password-request',
        component: ResetPasswordRequest,
        beforeEnter(to, from, next) {
            if (!authService.isLoggedIn()) {
                next();
            } else {
                next('/admin');
            }
        }
    },
    {
        path: '/reset-password/:email',
        name: 'reset-password',
        component: ResetPassword,
        beforeEnter(to, from, next) {
            if (!authService.isLoggedIn()) {
                next();
            } else {
                next('/admin');
            }
        }
    },
    {
        path: '*',
        name: '404',
        component: () => import('./components/templates/404.vue')
    }
];

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    linkActiveClass: 'active'
});

export default router;