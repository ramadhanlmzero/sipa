<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Input Data Hak Akses</h4>
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
        name: 'role_create',
        data() {
            return {
                role: {
                    type: ''
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.post('/api/roleapi', this.role).then(response => {
                    this.$router.push({name: 'role_index'})
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

