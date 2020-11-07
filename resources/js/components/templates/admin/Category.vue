<template>
 <div class="card mb-4">
    <div class="card-header d-flex">
        <i class="fas fa-table mr-1"></i>
        Categories
        <button @click="showNewCategoryModal" class="btn btn-primary ml-auto btn-sm" >Tạo danh mục mới</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Hình ảnh</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
               
                <tbody>
                   
                   <tr v-for="(category, index) in categories" :key="index">
                        <td>{{ index +1}}</td>
                        <td>{{ category.name }}</td>
                        <td><img width="100px" :src="`${$store.state.serverPath}/storage/${category.image}`" :alt="category.name"></td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click="editCategory(category)">Edit</button>
                            <button class="btn btn-warning btn-sm" @click="deleteCategory(category)">Delete</button>
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

    <b-modal ref="newCategoryModal" hide-footer title="Thêm danh mục sản phẩm">
      <div class="d-block text-center">
          <form @submit.prevent="createCategory">
              <div class="form-group text-left">
                <label for="name">Tên danh mục</label>
                <input type="text" v-model="categoryData.name" id="name" class="form-control" placeholder="Nhập tên danh mục...">
                <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0]}}</div>
              </div>
            <div class="form-group text-left">
                <label for="image">Chọn ảnh danh mục</label>
                <div v-if="categoryData.image.name" class="pb-2">
                    <img src="" ref="newCategoryImagesDisplay" alt="" class="w-150px">
                </div>
                <input type="file" v-on:change="attachImage" ref="newCategoryImage" id="image" class="form-control ">
                 <div class="invalid-feedback" v-if="errors.image">{{ errors.image[0]}}</div>
            </div>

            <button class="btn btn-warning" @click="hideNewCategoryModal">Đóng</button>
            <button type="submit" class="btn btn-primary">Lưu</button>
          </form>
        </div>
    </b-modal>

    <b-modal ref="editCategoryModal" hide-footer title="Cập nhật danh mục sản phẩm">
      <div class="d-block text-center">
          <form @submit.prevent="updateCategory">
              <div class="form-group text-left">
                <label>Tên danh mục</label>
                <input type="text" v-model="editCategoryData.name"  class="form-control" placeholder="Nhập tên danh mục...">
                <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0]}}</div>
              </div>
            <div class="form-group text-left">
                <label>Chọn ảnh danh mục</label>
                <div class="pb-2">
                    <img :src="`${$store.state.serverPath}/storage/${editCategoryData.image}`" ref="editCategoryImagesDisplay" alt="" class="w-150px">
                </div>
                <input type="file" v-on:change="editAttachImage" ref="editCategoryImage" class="form-control ">
                 <div class="invalid-feedback" v-if="errors.image">{{ errors.image[0]}}</div>
            </div>

            <button class="btn btn-warning" @click="hideEditCategoryModal">Đóng</button>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
          </form>
        </div>
    </b-modal>

</div>
</template>

<script>
import * as categoryService from '../../../services/category_service.js';
export default {
    name: 'category',
    data() {
        return {
            categories: [],
            categoryData: {
                name: '',
                image: '',
            },
            moreExists: false,
            nextPage: 0,
            editCategoryData: {},
            errors: {}
        }
    },
    mounted() {
        this.loadCategories()
    },

    methods: {
        loadCategories: async function() {
            try {
                const response = await categoryService.loadCategories();
                this.categories = response.data.data;

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
                const response = await categoryService.loadMore(this.nextPage);
                if (response.data.current_page < response.data.last_page) {
                    this.moreExists = true;
                    this.nextPage = response.data.current_page + 1
                } else {
                    this.moreExists = false;
                }

                response.data.data.forEach(data => {
                    this.categories.push(data);
                })
            } catch (error) {
                
            }
        },

        attachImage() {
            this.categoryData.image = this.$refs.newCategoryImage.files[0];
            let reader = new FileReader();
            reader.addEventListener('load', function() {
                this.$refs.newCategoryImagesDisplay.src = reader.result;
            }.bind(this), false);

            reader.readAsDataURL(this.categoryData.image);
        },

        hideNewCategoryModal() {
            this.$refs['newCategoryModal'].hide()
        },

        showNewCategoryModal() {
            this.$refs['newCategoryModal'].show()
        },

        createCategory: async function() {
            let formData = new FormData();
            formData.append('name', this.categoryData.name);
            formData.append('image', this.categoryData.image);

            try {
                const response = await categoryService.createCategory(formData);
                this.hideNewCategoryModal();
                this.categories.unshift(response.data);
                this.categoryData = {
                    name: '',
                    image: ''
                }
                
                this.flashMessage.success({
                    message: 'Tạo danh mục sản phẩm thành công!',
                    time: 2000
                });
                console.log(response);
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;
                
                    default:
                        this.hideNewCategoryModal();
                        this.flashMessage.error({
                            message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                            time: 2000
                        });
                        break;
                }
                console.log(error.response.status);
            }
        },

        deleteCategory: async function(category) {
            if (!window.confirm(`Bạn có chắc chắn muốn xóa ${category.name} không!`)) {
                return
            }

            try {
                const response = await categoryService.deleteCategory(category.id);
                this.categories = this.categories.filter(object =>{
                    return object.id != category.id
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

        hideEditCategoryModal() {
            this.$refs['editCategoryModal'].hide()
        },

        showEditCategoryModal() {
            this.$refs['editCategoryModal'].show()
        },

        editCategory(category) {
            this.editCategoryData = {...category};
            this.showEditCategoryModal();
        },

        editAttachImage() {
            this.editCategoryData.image = this.$refs.editCategoryImage.files[0];
            let reader = new FileReader();
            reader.addEventListener('load', function() {
                this.$refs.editCategoryImagesDisplay.src = reader.result;
            }.bind(this), false);

            reader.readAsDataURL(this.editCategoryData.image);
        },

        updateCategory: async function() {
            try {
                const formData =  new FormData();
                formData.append('name', this.editCategoryData.name);
                formData.append('image', this.editCategoryData.image);
                formData.append('_method', "put");
                
                const response = await categoryService.updateCategory(this.editCategoryData.id, formData);
                this.categories.map(category => {
                    if (category.id == response.data.id) {
                        for (let key in response.data) {
                            category[key] = response.data[key];
                        }
                    }
                });
                this.hideEditCategoryModal();
                this.flashMessage.success({
                    message: response.data.message,
                    time: 2000
                });
            } catch (error) {
                console.log(error);
                this.flashMessage.error({
                    message: response.data.message,
                    time: 2000
                });
            }
        }
    },
}
</script>

<style>

</style>