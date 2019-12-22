<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Input Data Kategori</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="code">Kode Kategori</label>
                        <input type="text" class="form-control" id="code" v-model="category.code" placeholder="contoh: PRO" required maxlength="10">
                    </div>
                    <div class="form-group row">
                        <label for="name">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" v-model="category.name" placeholder="contoh: proposal" required>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'category_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'category_create',
        data() {
            return {
                category: {
                    name: '',
                    code: ''
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.post('/api/categoryapi', this.category).then(response => {
                    this.$router.push({name: 'category_index'})
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
