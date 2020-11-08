import store from '../store.js';
import axios from 'axios';
import * as authService from './auth_service.js';

export function http() {
    return axios.create({
        baseUrl: store.state.apiURL,
        headers: {
            Authorization: 'Bearer ' + authService.getAccessToken(),
        }
    });
}

export function httpFile() {
    return axios.create({
        baseUrl: store.state.apiURL,
        headers: {
            Authorization: 'Bearer ' + authService.getAccessToken(),
            'Content-Type': 'multipart/form-data'
        }
    });
}