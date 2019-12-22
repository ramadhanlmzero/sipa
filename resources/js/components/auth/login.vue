<template>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
                    <div class="row w-100">
                        <div class="col-lg-8 mx-auto">
                            <div class="row">
                                <div class="col-lg-6 bg-white">
                                    <div class="auth-form-light text-left p-5">
                                        <h2>Masuk</h2>
                                        <h4 class="font-weight-light">Selamat datang di SIPA</h4>
                                        <form class="pt-5" @submit.prevent="login" method="post">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <div class="alert alert-danger" v-if="has_error">
                                                <span>Pastikan email / password anda benar !</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" v-model="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password">Password</label>
                                                <input type="password" v-model="password" class="form-control" id="password" placeholder="Password" data-toggle="password" required>
                                            </div>
                                            <div class="icheck-peterriver">
                                                <input type="checkbox" id="rememberme" v-model="remember" :value="true">
                                                <label for="rememberme" class="text-small">Ingat Saya</label>
                                            </div>
                                            <div class="mt-5">
                                                <button type="submit" class="btn btn-block btn-success btn-lg font-weight-medium">Masuk</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 login-half-bg d-flex flex-row">
                                    <p class="text-black font-weight-medium text-center flex-grow align-self-end">Developed by Dicode Team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login",
        data () {
            return {
                email: '',
                password: '',
                has_error: false,
                remember: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        methods: {
            login() {
                // var redirect = this.$auth.redirect()
                this.$auth.login({
                    params: {
                        email: this.email,
                        password: this.password
                    },
                    success: function() {
                        this.$router.push({name: 'dashboard'})
                    },
                    error: function() {
                        this.has_error = true
                    },
                    rememberMe: this.remember,
                    fetchUser: true
                })
            },
            showPassword() {
                $('#password').attr('type',$('#checkbox').prop('checked')==true?"text":"password")
            }
        }
    }
</script>

<style scoped>
    .auth .login-half-bg {
        background: url(/assets/images/login-pic.jpg);
        background-size: cover;
    }
    .auth form .form-group i {
        top: calc(53%);
    }
</style>
