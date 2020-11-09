import {http, httpFile} from './http_service.js';

export function userScope() {
    return http().get('api/user-scope');
}

export function adminScope() {
    return http().get('api/admin-scope');
}