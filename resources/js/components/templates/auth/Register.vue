<template>
<div class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Tạo tài khoản</h3></div>
                                <div class="card-body">
                                    <form @submit.prevent="register">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputFirstName">Họ và tên</label>
                                            <input v-model="user.name" class="form-control py-4" id="inputFirstName" type="text" placeholder="Họ và tên" />
                                            <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0]}}</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                            <input v-model="user.email" class="form-control py-4" id="iputEmailAddress" type="email" placeholder="Email đăng nhập" />
                                            <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0]}}</div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputPassword">Mật khẩu</label>
                                                    <input v-model="user.password" class="form-control py-4" id="inputPassword" type="password" placeholder="Mật khẩu" />
                                                    <div class="invalid-feedback" v-if="errors.password">{{ errors.password[0]}}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputConfirmPassword">Xác nhận lại mật khẩu</label>
                                                    <input v-model="user.password_confirmation" class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="Xác nhận lại mật khẩu" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary btn-block">Tạo tài khoản</button>

                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small">
                                        <router-link :to="{name: 'login'}">Bạn đã có tài khoản? Đăng nhập ngay</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
</template>

<script>
    import * as authService from './../../../services/auth_service.js';
    export default {
        data() {
            return {
                user: {
                    'name': '',
                    'email': '',
                    'password': '',
                    'password_confirmation': '',
                },
                errors: {}
            }
        },

        methods: {
            register: async function() {
                try {
                    const response = await authService.register(this.user);
                    this.errors = {};
                    this.flashMessage.success({
                        message: response.data.message,
                        time: 2000
                    });
                    this.$router.push('/login');
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;

                        case 500:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 2000
                            });
                            break;
                    
                        default:
                            this.flashMessage.error({
                                message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                                time: 2000
                            });
                            break;
                    }
                }
            }
        },
    }
</script>

<style>
</style>