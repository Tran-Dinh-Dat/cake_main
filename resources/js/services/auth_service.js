import {http, httpFile} from './http_service.js';
import jwt from 'jsonwebtoken';

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

function setToken(user) {
    const token = jwt.sign({ user: user }, 'laravelspatoken');
    localStorage.setItem('laravel-vue-spa-token', token);
}

export function isLoggedIn() {
    const token =  localStorage.getItem('laravel-vue-spa-token');
    return token != null;
}