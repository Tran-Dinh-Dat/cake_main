<template>
    <div class="sb-nav-fixed">
        <router-view></router-view>
        <FlashMessage position="right top"/>
    </div>
</template>

<script>
    import * as authService from "./services/auth_service.js";
    export default {
        beforeCreate: async function() {
            try {
                if (authService.isLoggedIn()) {
                    const response = await authService.getProfile();
                    console.log(response);
                    this.$store.dispatch('authenticate', response.data);
                }
            } catch (error) {
                authService.logout();
            }
        },
    }
</script>

<style>

</style>