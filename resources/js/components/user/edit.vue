<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Reset Password {{ user.name }}</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" id="password" v-model="user.password" placeholder="contoh: test123" required>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'user_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'user_edit',
        data() {
            return {
                user: {
                    name: '',
                    password: ''
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/userapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.user = response.data
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/userapi/' + this.$route.params.id, this.user).then(response => {
                    this.$router.push({name: 'user_index'})
                    this.$swal({
                        title: 'Sukses!',
                        text: 'Data berhasil dimasukkan',
                        type: 'success',
                    })
                })
            }
        }
    }
</script>
