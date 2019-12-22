<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="/"><img src="/assets/images/logo.jpg" alt="logo" /></a>
            <button class="navbar-toggler d-lg-none align-self-center" type="button" v-on:click="toggle" >
                <span class="icon-menu"></span>
            </button>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav">
                <li class="nav-item dropdown d-none d-lg-flex">
                    <router-link :to="{ name:'archive_create' }" class="nav-link nav-btn">
                        <span class="btn">+ Unggah Arsip</span>
                    </router-link>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right d-none d-sm-block">
                <li class="nav-item dropdown d-none d-lg-flex">
                    <a class="nav-link dropdown-toggle" id="menuDropdown" @click="dropdown">
                    {{ this.$auth.user().user.name }}
                    </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="menuDropdown">
                        <router-link :to="{ name:'account_index' }" class="dropdown-item font-weight-medium">
                            <i class="icon-wrench pr-2"></i>
                            Kelola Akun
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#" @click.prevent='logout'>
                            <i class="icon-logout pr-2"></i>
                            Keluar
                        </a>
                    </div>
                </li>
            </ul>
            <router-link :to="{ name:'account_index' }" class="navbar-toggler navbar-toggler-right d-lg-none align-self-center">
                <span class="icon-wrench"></span>
            </router-link>
        </div>
    </nav>
</template>

<script>
    export default {
        name: 'navbar',
        methods: {
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    redirect: '/login'
                })
            },
            toggle() {
                $('.row-offcanvas').toggleClass('active')
            },
            dropdown() {
                $('.dropdown').toggleClass('show')
                $('.dropdown-menu').toggleClass('show')
            }
        }
    }
</script>

<style>
    @media screen and (max-width: 991px) {
        .navbar .navbar-brand-wrapper {
            background: transparent;
            color: white;
        }
        .navbar .navbar-brand-wrapper .navbar-toggler {
            color: inherit;
        }
    }
</style>

