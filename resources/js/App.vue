<template>
    <div class="sb-nav-fixed">
        <router-view></router-view>
        <FlashMessage position="right top"/>
    </div>
</template>

<script>
import Nav from './components/common/admin/Nav.vue';
import Sidebar from './components/common/admin/Sidebar.vue';
import Footer from './components/common/admin/Footer.vue';
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