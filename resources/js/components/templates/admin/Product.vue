<template>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Sản phẩm</h1>
        <ol class="breadcrumb mb-4">
            <router-link :to="{name: 'admin.dashboard'}" class="breadcrumb-item">Dashboard </router-link>
            <a class="breadcrumb-item active">Sản phẩm</a>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex">
                <i class="fas fa-table mr-1"></i>
                Tât cả sản phẩm
                <button  @click="showNewProductModal" class="btn btn-primary ml-auto btn-sm" >Thêm sản phẩm mới</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên sản phẩn</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
                                <th>Giá chiết khẩu</th>
                                <th>Số lượng</th>
                                <th>Danh mục</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products" :key="index">
                                <td>{{ index +1}}</td>
                                <td>{{ product.name }}</td>
                                <td><img width="100px" :src="`${$store.state.serverPath}/storage/${product.image}`" :alt="product.name"></td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.discount }}</td>
                                <td>{{ product.quantity }}</td>
                                <td>{{ findCategory(product.category_id) }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" @click="editProduct(product)">Edit</button>
                                    <button class="btn btn-warning btn-sm" @click="deleteProduct(product)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center" v-show="moreExists">
                        <button @click="loadMore" type="button" class="btn btn-primary btn-sm">
                            Xem thêm <i class="fa fa-arrow-down" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <b-modal size="lg" ref="newProductModal" hide-footer title="Thêm sản phẩm">
            <div class="d-block text-center">
                <form @submit.prevent="createProduct" class="text-left">
                    <div class="form-group text-left">
                        <label>Tên sản phẩm</label>
                        <input type="text" v-model="productData.name" class="form-control" placeholder="Nhập tên danh mục...">
                        <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0]}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group text-left">
                                <label>Tên danh mục</label>
                                <select v-model="productData.category_id" class="form-control">
                                    <option value="">---Chọn danh mục sản phẩm---</option>
                                    <option v-for="(category) in categories" :value="category.id" :key="category.id">{{category.name }}</option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0]}}</div>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group text-left">
                                <label>Số lượng sản phẩm</label>
                                <input type="text" v-model="productData.quantity" class="form-control" placeholder="Nhập số lượng sản phẩm...">
                                <div class="invalid-feedback" v-if="errors.quantity">{{ errors.quantity[0]}}</div>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group text-left">
                                <label>Mã sản phẩm</label>
                                <input type="text" v-model="productData.sku" class="form-control" placeholder="Nhập mã sản phẩm...">
                                <div class="invalid-feedback" v-if="errors.sku">{{ errors.sku[0]}}</div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group text-left">
                                <label>Giá sản phẩm</label>
                                <input type="text" v-model="productData.price" class="form-control" placeholder="Nhập giá sản phẩm...">
                                <div class="invalid-feedback" v-if="errors.price">{{ errors.price[0]}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-left">
                                <label>Giá hiết khẩu</label>
                                <input type="text" v-model="productData.discount" class="form-control" placeholder="Nhập giá chiết khấu...">
                                <div class="invalid-feedback" v-if="errors.discount">{{ errors.discount[0]}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="">Mô tả ngắn</label>
                      <textarea v-model="productData.description" class="form-control" rows="3"></textarea>
                      <div class="invalid-feedback" v-if="errors.description">{{ errors.description[0]}}</div>
                    </div>

                    <div class="form-group">
                      <label for="">Nội dung của sản phẩm</label>
                      <textarea v-model="productData.content" class="form-control" rows="5"></textarea>
                      <div class="invalid-feedback" v-if="errors.content">{{ errors.content[0]}}</div>
                    </div>
                    
                    <div class="form-group text-left">
                        <label for="image">Chọn ảnh sản phẩm</label>
                        <div v-if="productData.image.name" class="pb-2">
                            <img src="" ref="newProductImagesDisplay" alt="" class="w-150px">
                        </div>
                        <input type="file" v-on:change="attachImage" ref="newProductImage" id="image" class="form-control ">
                        <div class="invalid-feedback" v-if="errors.image">{{ errors.image[0]}}</div>
                    </div>

                    <button class="btn btn-warning" @click="hideNewProductModal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
                </div>
            </b-modal>

            <b-modal size="lg" ref="editProductModal" hide-footer title="Cập nhật sản phẩm">
            <div class="d-block text-center">
                <form @submit.prevent="updateProduct" class="text-left">
                    <div class="form-group text-left">
                        <label>Tên sản phẩm</label>
                        <input type="text" v-model="editProductData.name" class="form-control" placeholder="Nhập tên danh mục...">
                        <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0]}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group text-left">
                                <label>Tên danh mục</label>
                                <select v-model="editProductData.category_id" class="form-control">
                                    <option value="">---Chọn danh mục sản phẩm---</option>
                                    <option v-for="(category) in categories" :value="category.id" :key="category.id">{{category.name }}</option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.category_id">{{ errors.category_id[0]}}</div>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group text-left">
                                <label>Số lượng sản phẩm</label>
                                <input type="text" v-model="editProductData.quantity" class="form-control" placeholder="Nhập số lượng sản phẩm...">
                                <div class="invalid-feedback" v-if="errors.quantity">{{ errors.quantity[0]}}</div>
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group text-left">
                                <label>Mã sản phẩm</label>
                                <input type="text" v-model="editProductData.sku" class="form-control" placeholder="Nhập mã sản phẩm...">
                                <div class="invalid-feedback" v-if="errors.sku">{{ errors.sku[0]}}</div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group text-left">
                                <label>Giá sản phẩm</label>
                                <input type="text" v-model="editProductData.price" class="form-control" placeholder="Nhập giá sản phẩm...">
                                <div class="invalid-feedback" v-if="errors.price">{{ errors.price[0]}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-left">
                                <label>Giá hiết khẩu</label>
                                <input type="text" v-model="editProductData.discount" class="form-control" placeholder="Nhập giá chiết khấu...">
                                <div class="invalid-feedback" v-if="errors.discount">{{ errors.discount[0]}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="">Mô tả ngắn</label>
                      <textarea v-model="editProductData.description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="">Nội dung của sản phẩm</label>
                      <textarea v-model="editProductData.content" class="form-control" rows="5"></textarea>
                    </div>
                    
                    <div class="form-group text-left">
                        <label>Chọn ảnh sản phẩm</label>
                        <div class="pb-2">
                            <img :src="`${$store.state.serverPath}/storage/${editProductData.image}`" ref="editProductImagesDisplay" alt="" class="w-150px">
                        </div>
                        <input type="file" v-on:change="editAttachImage" ref="editProductImage" class="form-control ">
                        <div class="invalid-feedback" v-if="errors.image">{{ errors.image[0]}}</div>
                    </div>

                    <button class="btn btn-warning" @click="hideEditProductModal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
                </div>
            </b-modal>

        </div>
    </div>
</main>
</template>

<script>
import * as productService from '../../../services/product_service.js';
export default {
    name: 'product',
    data() {
        return {
            categories: [],
            products: [],
            productData: {
                category_id: '',
                name: '',
                image: '',
                sku: '',
                description: '',
                content: '',
                price: 0,
                discount: 0,
                quantity: 0,
                views: 0,
            },
            moreExists: false,
            nextPage: 0,
            editProductData: {},
            errors: {}
        }
    },
    mounted() {
        this.loadCategories(),
        this.loadProducts()
    },

    methods: {
        
        loadCategories: async function() {
            try {
                const response = await productService.loadCategories();
                this.categories = response.data;
                if (response.data.current_page < response.data.last_page) {
                    this.moreExists = true;
                    this.nextPage = response.data.current_page + 1
                } else {
                    this.moreExists = false;
                }
            } catch (error) {
                this.flashMessage.error({
                    message: 'Có lỗi xảy ra, vui lòng tải lại trang!',
                    time: 2000
                });
            }
        },

        loadProducts: async function() {
            try {
                const response = await productService.loadProducts();
                this.products = response.data.data;

                if (response.data.current_page < response.data.last_page) {
                    this.moreExists = true;
                    this.nextPage = response.data.current_page + 1
                } else {
                    this.moreExists = false;
                }
            } catch (error) {
                this.flashMessage.error({
                    message: 'Có lỗi xảy ra, vui lòng tải lại trang!',
                    time: 2000
                });
            }
        },

        loadMore: async function() {
            try {
                const response = await productService.loadMore(this.nextPage);
                if (response.data.current_page < response.data.last_page) {
                    this.moreExists = true;
                    this.nextPage = response.data.current_page + 1
                } else {
                    this.moreExists = false;
                }

                response.data.data.forEach(data => {
                    this.products.push(data);
                })
            } catch (error) {
                
            }
        },

        attachImage() {
            this.productData.image = this.$refs.newProductImage.files[0];
            let reader = new FileReader();
            reader.addEventListener('load', function() {
                this.$refs.newProductImagesDisplay.src = reader.result;
            }.bind(this), false);

            reader.readAsDataURL(this.productData.image);
        },

        hideNewProductModal() {
            this.$refs['newProductModal'].hide()
        },

        showNewProductModal() {
            this.$refs['newProductModal'].show()
        },

        createProduct: async function() {
            let formData = new FormData();
            formData.append('category_id', this.productData.category_id);
            formData.append('name', this.productData.name);
            formData.append('image', this.productData.image);
            formData.append('sku', this.productData.sku);
            formData.append('description', this.productData.description);
            formData.append('content', this.productData.content);
            formData.append('price', this.productData.price);
            formData.append('discount', this.productData.discount);
            formData.append('quantity', this.productData.quantity);
            formData.append('views', this.productData.views);

            try {
                const response = await productService.createProduct(formData);
                this.hideNewProductModal();
                this.products.unshift(response.data);
                this.productData = {
                    category_id: '',
                    name: '',
                    image: '',
                    sku: '',
                    description: '',
                    content: '',
                    price: 0,
                    discount: 0,
                    quantity: 0,
                    views: 0,
                }
                
                this.flashMessage.success({
                    message: 'Tạo danh mục sản phẩm thành công!',
                    time: 2000
                });
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                
                    default:
                        this.hideNewProductModal();
                        this.errors = error.response.data.errors;

                        this.flashMessage.error({
                            message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                            time: 2000
                        });
                        break;
                }
            }
        },

        deleteProduct: async function(product) {
            if (!window.confirm(`Bạn có chắc chắn muốn xóa ${product.name} không!`)) {
                return
            }

            try {
                const response = await productService.deleteProduct(product.id);
                this.products = this.products.filter(object =>{
                    return object.id != product.id
                })
                this.flashMessage.success({
                    message: response.data.message,
                    time: 2000
                });
            } catch (error) {
                this.flashMessage.error({
                    message: response.data.message,
                    time: 2000
                });
            }
        },

        hideEditProductModal() {
            this.$refs['editProductModal'].hide()
        },

        showEditProductModal() {
            this.$refs['editProductModal'].show()
        },

        editProduct(product) {
            this.editProductData = {...product};
            this.showEditProductModal();
        },

        editAttachImage() {
            this.editProductData.image = this.$refs.editProductImage.files[0];
            let reader = new FileReader();
            reader.addEventListener('load', function() {
                this.$refs.editProductImagesDisplay.src = reader.result;
            }.bind(this), false);

            reader.readAsDataURL(this.editProductData.image);
        },

        updateProduct: async function() {
            try {
                const formData =  new FormData();
                formData.append('category_id', this.editProductData.category_id);
                formData.append('name', this.editProductData.name);
                formData.append('image', this.editProductData.image);
                formData.append('sku', this.editProductData.sku);
                formData.append('description', this.editProductData.description);
                formData.append('content', this.editProductData.content);
                formData.append('price', this.editProductData.price);
                formData.append('discount', this.editProductData.discount);
                formData.append('quantity', this.editProductData.quantity);
                formData.append('_method', "put");
                
                const response = await productService.updateProduct(this.editProductData.id, formData);
                this.products.map(product => {
                    if (product.id == response.data.id) {
                        for (let key in response.data) {
                            product[key] = response.data[key];
                        }
                    }
                });
                this.hideEditProductModal();
                this.flashMessage.success({
                    message: response.data.message,
                    time: 2000
                });
            } catch (error) {
               this.errors = error.response.data.errors;
                this.flashMessage.error({
                    message: response.data.message,
                    time: 2000
                });
            }
        },

        findCategory(category_id) {
            let category_name = '';
            this.categories.forEach(category => {
                if (category.id == category_id) {
                    category_name = category.name;
                }
            });
            return category_name;
        }
    },
}
</script>

<style>
 
</style>