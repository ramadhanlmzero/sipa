<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar" >
        <ul class="nav" v-if="$auth.user().role">
            <li class="nav-item nav-profile">
                <div class="nav-link">
                    <div class="profile-image">
                        <img src="/assets/images/admin-pic.png" alt="image" />
                    </div>
                    <div class="profile-name">
                        <p class="name" v-if="$auth.user().user">
                            {{ $auth.user().user.name }}
                        </p>
                        <p class="designation" v-if="$auth.user().role">
                            <span v-for="(item, counter) in $auth.user().role" :key="counter">
                                {{ item.type }}
                                <span v-if="counter+1 < $auth.user().role.length">, </span>
                            </span>
                        </p>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <router-link :to="{ name:'dashboard' }" class="nav-link" @click.native="toggle">
                    <i class="icon-rocket menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{ name:'archive_index' }" class="nav-link" @click.native="toggle">
                    <i class=" icon-notebook menu-icon"></i>
                    <span class="menu-title">Data Arsip</span>
                </router-link>
            </li>
            <template v-for="(item, counter) in $auth.user().role">
                <li class="nav-item" v-if="item.type === 'Superadmin' || item.type === 'Staf Tata Usaha'" v-bind:key="counter">
                    <router-link :to="{ name:'category_index' }" class="nav-link" @click.native="toggle">
                        <i class="icon-layers menu-icon"></i>
                        <span class="menu-title">Data Kategori</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="item.type === 'Superadmin' || item.type === 'Staf Tata Usaha'" v-bind:key="counter+0.5">
                    <router-link :to="{ name:'room_index' }" class="nav-link" @click.native="toggle">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Data Ruangan</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="item.type === 'Superadmin' || item.type === 'Staf Tata Usaha'" v-bind:key="counter+1">
                    <router-link :to="{ name:'rack_index' }" class="nav-link" @click.native="toggle">
                        <i class="icon-social-dropbox menu-icon"></i>
                        <span class="menu-title">Data Rak</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="item.type === 'Superadmin'" v-bind:key="counter+2">
                    <router-link :to="{ name:'user_index' }" class="nav-link" @click.native="toggle">
                        <i class="icon-user menu-icon"></i>
                        <span class="menu-title">Data User</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="item.type === 'Superadmin'" v-bind:key="counter+3">
                    <router-link :to="{ name:'role_index' }" class="nav-link" @click.native="toggle">
                        <i class="icon-briefcase menu-icon"></i>
                        <span class="menu-title">Data Role</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="item.type === 'Superadmin'" v-bind:key="counter+4">
                    <router-link :to="{ name:'userrole_index' }" class="nav-link" @click.native="toggle">
                        <i class="icon-people menu-icon"></i>
                        <span class="menu-title">Pengaturan Hak Akses</span>
                    </router-link>
                </li>
            </template>
            <li class="nav-item nav-doc d-lg-none">
                <a class="nav-link bg-danger count-indicator" href="#" @click.prevent='logout'>
                    <i class="icon-logout menu-icon"></i>
                    <span class="menu-title">Keluar</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: 'sidebar',
        data() {
            return {
            }
        },
        methods: {
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    redirect: '/login'
                })
            },
            toggle(){
                $('.row-offcanvas').toggleClass('active')
            }
        }
    }
</script>

