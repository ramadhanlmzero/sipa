<template>
    <div class="container-scroller">
        <navbar></navbar>
        <div class="container-fluid page-body-wrapper">
            <div class="row row-offcanvas row-offcanvas-left">
                <sidebar></sidebar>
                <div class="content-wrapper">
                    <transition name="fade">
                        <router-view></router-view>
                    </transition>
                </div>
                <foot></foot>
            </div>
        </div>
    </div>
</template>

<script>
    import navbar from './navbar.vue'
    import sidebar from './sidebar.vue'
    import foot from './footer.vue'
    export default {
        name: 'index',
        components: {
            navbar, sidebar, foot
        }
    }
</script>
