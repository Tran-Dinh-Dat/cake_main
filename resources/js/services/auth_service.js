import {http, httpFile} from './http_service.js';

export function register(user) {
    return http().post('api/auth/register', user);
}
