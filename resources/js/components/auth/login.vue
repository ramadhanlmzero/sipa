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
                                <div class="col-lg-6 bg-white py-4">
                                    <div class="list list-row my-4">
                                        <h6 class="font-weight-bold">Anggota Dicode Team</h6>
                                        <div class="list-item mb-3" data-id="19">
                                            <div>
                                               <span class="w-48 avatar gd-primary">
                                                   <img src="https://siakadu.unesa.ac.id/photo/fotomhs/16051204011.jpg" height="74" alt="Mazidhatul Ilmiyah">
                                                </span>
                                            </div>
                                            <div class="flex col-md-7">
                                                <span class="item-author text-primary">Mazidhatul Ilmiyah</span>
                                                <div class="item-except text-muted text-sm h-1x">Designer</div>
                                            </div>
                                            <div class="no-wrap col-md">
                                                <div class="item-date text-muted text-sm d-none d-md-block">16051204011</div>
                                            </div>
                                        </div>
                                        <div class="list-item mb-3" data-id="7">
                                            <div>
                                               <span class="w-48 avatar gd-primary">
                                                   <img src="https://siakadu.unesa.ac.id/photo/fotomhs/16051204013.jpg" height="74" alt="Dyah Hediyati">
                                                </span>
                                            </div>
                                            <div class="flex col-md-7"> 
                                                <span class="item-author text-primary">Dyah Hediyati</span>
                                                <div class="item-except text-muted text-sm h-1x">Proposal Author</div>
                                            </div>
                                            <div class="no-wrap col-md">
                                                <div class="item-date text-muted text-sm d-none d-md-block">16051204013</div>
                                            </div>
                                        </div>
                                        <div class="list-item mb-3" data-id="17">
                                            <div>
                                               <span class="w-48 avatar gd-primary">
                                                   <img src="https://siakadu.unesa.ac.id/photo/fotomhs/16051204017.jpg" height="74" alt="Muhamad Ramadhan">
                                                </span>
                                            </div>
                                            <div class="flex col-md-7"> 
                                                <span class="item-author text-primary">Muhamad Ramadhan</span>
                                                <div class="item-except text-muted text-sm h-1x">Programmer</div>
                                            </div>
                                            <div class="no-wrap col-md">
                                                <div class="item-date text-muted text-sm d-none d-md-block">16051204017</div>
                                            </div>
                                        </div>
                                        <div class="list-item mb-3" data-id="16">
                                            <div>
                                               <span class="w-48 avatar gd-primary">
                                                   <img src="https://siakadu.unesa.ac.id/photo/fotomhs/16051204042.jpg" height="74" alt="Ahmad Rizki Maulana">
                                                </span>
                                            </div>
                                            <div class="flex col-md-7"> 
                                                <span class="item-author text-primary">Ahmad Rizki Maulana</span>
                                                <div class="item-except text-muted text-sm h-1x">Administrator Web</div>
                                            </div>
                                            <div class="no-wrap col-md">
                                                <div class="item-date text-muted text-sm d-none d-md-block">16051204042</div>
                                            </div>
                                        </div>
                                        <div class="list-item mb-3" data-id="4">
                                            <div>
                                               <span class="w-48 avatar gd-primary">
                                                   <img src="https://siakadu.unesa.ac.id/photo/fotomhs/16051204043.jpg" height="74" alt="Farid Fajar Shodiq">
                                                </span>
                                            </div>
                                            <div class="flex col-md-7"> 
                                                <span class="item-author text-primary">Farid Fajar Shodiq</span>
                                                <div class="item-except text-muted text-sm h-1x">Administrator Web</div>
                                            </div>
                                            <div class="no-wrap col-md">
                                                <div class="item-date text-muted text-sm d-none d-md-block">16051204043</div>
                                            </div>
                                        </div>
                                    </div>
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
    .list {
        padding-left: 0;
        padding-right: 0
    }
    .list-item {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word
    }
    .list-row .list-item {
        -ms-flex-direction: row;
        flex-direction: row;
        -ms-flex-align: center;
        align-items: center;
        padding: .75rem .625rem
    }
    .list-row .list-item>* {
        padding-left: .625rem;
        padding-right: .625rem
    }
    .no-wrap {
        white-space: nowrap
    }
    .avatar {
        position: relative;
        line-height: 1;
        border-radius: 500px;
        white-space: nowrap;
        font-weight: 700;
        border-radius: 100%;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        border-radius: 500px;
        box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
    }
    .avatar img {
        border-radius: inherit;
        width: 100%
    }
    .text-sm {
        font-size: .825rem
    }

    .h-1x {
        height: 1.25rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical
    }

    .w-48 {
        width: 48px !important;
        height: 48px !important
    }
</style>
