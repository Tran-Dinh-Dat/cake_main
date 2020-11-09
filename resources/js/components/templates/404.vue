<template>
         <div id="layoutError">
            <div id="layoutError_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mt-4">
                                    <img class="mb-4 img-error" src="../../public/images/error-404-monochrome.svg" />
                                    <p class="lead">URL được yêu cầu này không được tìm thấy trên máy chủ này.</p>
                                    <router-link to="/admin">
                                        <i class="fas fa-arrow-left mr-1"></i>
                                        Quay về Dashboard
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutError_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Bản quyền &copy; Cake 2020</div>
                            <div>
                                <a href="#">Chính sách bảo mật</a>
                                &middot;
                                <a href="#">Chính sách &amp; Điều khoản</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
</template>

<script>
export default {

}
</script>

<style>

</style>