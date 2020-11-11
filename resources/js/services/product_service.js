import {http, httpFile} from './http_service.js';

export function createProduct(data) {
    return httpFile().post('/api/products', data);
}

export function loadProducts() {
    return http().get('/api/products');
}

export function loadCategories() {
    return http().get('/api/get-categories');
}

export function deleteProduct(id) {
    return http().delete(`/api/products/${id}`);
}

export function updateProduct(id, data) {
    return httpFile().post(`/api/products/${id}`, data);
}

export function loadMore(nextPage) {
    return http().get(`/api/products?page=${nextPage}`);
}