<template>
    <div class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Đăng nhập</h3></div>
                                    <div class="card-body">
                                        <form @submit.prevent="login">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input v-model="user.email" class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Email" />
                                                <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Mật khẩu</label>
                                                <input v-model="user.password" class="form-control py-4" id="inputPassword" type="password" placeholder="Mật khẩu" />
                                                <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input v-model="user.remember_me" class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Lưu mật khẩu</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <router-link :to="{name: 'reset-password-request'}" class="small">Quên mật khẩu?</router-link>
                                                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">

                                        <div class="small">
                                            <router-link :to="{name: 'register'}">Chưa có tài khoản? Đăng ký ngay!</router-link>
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
                    'email': '',
                    'password': '',
                    'remember_me': false
                },
                errors: {}
            }
        },
        methods: {
            login: async function() {
                try {
                    const response = await authService.login(this.user);
                    this.errors = {};
                    this.$router.push('/admin');
                    this.flashMessage.success({
                        message: response.data.message,
                        time: 2000
                    })
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            break;

                        case 401:
                            this.flashMessage.error({
                                message: error.response.data.message,
                                time: 2000
                            });
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