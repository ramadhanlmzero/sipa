<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Perbarui Data Anda</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" v-model="account.name" placeholder="contoh: jason" required>
                    </div>
                    <div class="form-group row">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" v-model="account.email" placeholder="contoh: email@gmail.com" required>
                    </div>
                    <div class="form-group row">
                        <label for="password">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password" v-model="account.password" placeholder="Masukkan password lama anda" required>
                        <small>Password dibutuhkan untuk melakukan perubahan data pada akun</small>
                    </div>
                    <div class="alert alert-danger row" v-if="has_error">
                        <span>Password salah</span>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'account_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'account_edit',
        data() {
            return {
                account: {
                    name: '',
                    email: '',
                    password: ''
                },
                has_error: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/userapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.account = response.data
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/updateuserapi/' + this.$route.params.id, this.account).then(response => {
                    if(response.data.status == "error") {
                        this.has_error = true
                    }
                    else {
                        this.has_error = false
                        this.$swal({
                            title: 'Sukses!',
                            text: 'Data berhasil dimasukkan',
                            type: 'success',
                            showConfirmButton: false
                        })
                        setTimeout(function () {
                            window.location.href = "/account"
                        }, 1000)
                    }
                })
            }
        }
    }
</script>
