import {http, httpFile} from './http_service.js';
import jwt from 'jsonwebtoken';
import store from './../store.js';

export function register(user) {
    return http().post('api/auth/register', user);
}

export function login(user) {   
    return http().post('api/auth/login', user)
    .then(response => {
        if (response.status === 200) {
            setToken(response.data);
        }

        return response.data;
    });
}

export function logout() {
    http().get('api/auth/logout');
    localStorage.removeItem('laravel-vue-spa-token');
}

function setToken(user) {
    const token = jwt.sign({ user: user }, 'laravelspatoken');
    localStorage.setItem('laravel-vue-spa-token', token);
    store.dispatch('authenticate', user.user);
}

export function isLoggedIn() {
    const token =  localStorage.getItem('laravel-vue-spa-token');
    return token != null;
}

export function getAccessToken() {
    const token = localStorage.getItem('laravel-vue-spa-token');
    if (!token) {
        return null;
    }

    const tokenData = jwt.decode(token);
    return tokenData.user.access_token;
}

export function getProfile() {
    return http().get('/api/auth/profile');
}