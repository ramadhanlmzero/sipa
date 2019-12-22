<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Input Data User</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" v-model="user.name" placeholder="contoh: jason" required>
                    </div>
                    <div class="form-group row">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" v-model="user.email" placeholder="contoh: email@gmail.com" required>
                    </div>
                    <div class="form-group row">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" v-model="user.password" placeholder="contoh: test123" required>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2 mt-4">Simpan</button>
                    <router-link :to="{ name:'user_index' }" class="btn btn-light mt-4">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'user_create',
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: ''
                },
                test: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.post('/api/userapi', this.user).then(response => {
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
