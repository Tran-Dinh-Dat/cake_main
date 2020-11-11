import {http, httpFile} from './http_service.js';

export function createCategory(data) {
    return httpFile().post('/api/categories', data);
}

export function loadCategories() {
    return http().get('/api/categories');
}

export function deleteCategory(id) {
    return http().delete(`/api/categories/${id}`);
}

export function updateCategory(id, data) {
    return httpFile().post(`/api/categories/${id}`, data);
}

export function loadMore(nextPage) {
    return http().get(`/api/categories?page=${nextPage}`);
}