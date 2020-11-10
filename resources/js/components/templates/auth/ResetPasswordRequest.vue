<template>
    <div class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Gửi yêu cầu khôi phục tài khoản</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Nhập địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn.</div>
                                        <form @submit.prevent="resetPassword">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input v-model="user.email" class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Nhập địa chỉ email..." />
                                                <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0]}}</div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <router-link :to="{name: 'login'}" class="small">Quay về trang đăng nhập</router-link>
                                                <button ref="btnSubmit" type="submit" class="btn btn-primary">Xác nhận</button>
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
                            <div class="text-muted">Copyright &copy; Cake 2020</div>
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
    import * as authService from '../../../services/auth_service.js';
    export default {
        data() {
            return {
                user: {
                    email: ''
                },
                errors: {},
                btnOldHtml: ''
            }
        },
        
        methods: {
            resetPassword: async function() {
                try {
                    this.errors = {};
                    this.disableSubmission(this.$refs.btnSubmit);
                    const response = await authService.resetPasswordRequest(this.user);
                    this.flashMessage.success({
                        message: response.data.message,
                        time: 2000
                    });
                    this.$router.push({name: 'reset-password', params: { email:this.user.email}});
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
                    this.enableSubmission(this.$refs.btnSubmit);
               } 
            },
            disableSubmission(btn) {
                btn.setAttribute('disabled', 'disabled');
                this.btnOldHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner"></i> Chờ ít giây nhé ...';
            },
            enableSubmission(btn) {
                btn.removeAttribute('disabled');
                btn.innerHTML = this.btnOldHtml;
            }
        }
    }
</script>

<style>

</style>