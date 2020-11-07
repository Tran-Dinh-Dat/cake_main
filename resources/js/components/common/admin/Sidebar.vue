<template>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <router-link class="nav-link" :to="{name: 'admin.home'}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </router-link>
                
                    <div class="sb-sidenav-menu-heading">Categories</div>
                     <router-link class="nav-link" :to="{name: 'admin.categories'}">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Categories
                    </router-link>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Products
                    </a>
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