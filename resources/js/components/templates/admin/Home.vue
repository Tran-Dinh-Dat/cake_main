<template>
    <div class="sb-nav-fixed">
        <Nav />
        <div id="layoutSidenav">
            <Sidebar />
            <div id="layoutSidenav_content">
                <router-view></router-view>
                <Footer />
            </div>
        </div>
        <FlashMessage position="right top"/>
    </div>
</template>

<script>
import Nav from './../../common/admin/Nav.vue';
import Sidebar from './../../common/admin/Sidebar.vue';
import Footer from './../../common/admin/Footer.vue';
export default {
    components: {
        Nav,
        Sidebar,
        Footer,
    },
}
</script>

<style>

</style>