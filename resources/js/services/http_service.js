import store from '../store';
import axios from 'axios';

export function http() {
    return axios.create({
        baseUrl: store.state.apiURL
    });
}

export function httpFile() {
    return axios.create({
        baseUrl: store.state.apiURL,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
}