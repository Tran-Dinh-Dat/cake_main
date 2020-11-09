<template>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <router-link class="nav-link" :to="{name: 'admin.dashboard'}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </router-link>
                
                    <router-link v-if="$store.state.profile.role === 'administrator'" class="nav-link" :to="{name: 'admin.categories'}">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Danh mục
                    </router-link>
                   <router-link v-if="$store.state.profile.role === 'user'" class="nav-link" :to="{name: 'admin.products'}">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Sản phẩm
                    </router-link>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div>
        </nav>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>