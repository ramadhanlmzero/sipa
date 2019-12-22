<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Perbarui Password Anda</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="password">Password Lama</label>
                        <input type="password" class="form-control" v-model="account.oldpassword" placeholder="Masukkan password lama anda" required>
                    </div>
                    <div class="form-group row">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" v-model="account.newpassword" placeholder="Masukkan password baru yang anda inginkan" required>
                    </div>
                    <div class="alert alert-danger row" v-if="has_error">
                        <span>Password lama anda salah</span>
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
                    oldpassword: '',
                    newpassword: ''
                },
                has_error: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/userapi/' + this.$route.params.id + '/edit')
                .then(response => {
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/changepasswordapi/' + this.$route.params.id, this.account).then(response => {
                    if(response.data.status == "error") {
                        this.has_error = true
                    }
                    else {
                        this.has_error = false
                        this.$swal({
                            title: 'Sukses!',
                            text: 'Password berhasil diubah! Silakan login dengan password baru',
                            type: 'success'
                        })
                        this.$auth.logout({
                            makeRequest: true,
                            redirect: '/login'
                        })
                    }
                })
            }
        }
    }
</script>
