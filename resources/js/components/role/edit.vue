<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Ubah Data Hak Akses {{ role.type }}</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="type">Jenis Hak Akses</label>
                        <input type="text" class="form-control" id="type" v-model="role.type" placeholder="contoh: admin" required>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'role_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'role_edit',
        data() {
            return {
                role: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/roleapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.role = response.data
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/roleapi/' + this.$route.params.id, this.role).then(response => {
                    this.$router.push({name: 'role_index'})
                    this.$swal({
                        title: 'Sukses!',
                        text: 'Data berhasil diubah',
                        type: 'success',
                    })
                })
            }
        }
    }
</script>
