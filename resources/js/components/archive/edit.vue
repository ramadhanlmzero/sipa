<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Ubah Data Arsip {{ archive.archive.number }}</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label>Kategori</label>
                        <input type="text" class="form-control"  v-model="archive.archive.c_category.name" readonly/>
                    </div>
                    <div class="form-group row">
                        <label>Rak Penyimpanan</label>
                        <select class="form-control" v-model="archive.archive.rack_id">
                            <option :value="archive.archive.c_rack.id" selected>{{ archive.archive.c_rack.name + ' - ' + archive.archive.c_rack.c_room.name }}</option>
                            <option v-for="(value, counter) in archive.rack" :key="counter" :value="value.id">{{ value.name + ' - ' + value.c_room.name }}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="number">Nomor Arsip</label>
                        <input type="text" class="form-control" id="number" v-model="archive.archive.number" readonly>
                    </div>
                    <div class="form-group row">
                        <label for="title">Judul Arsip</label>
                        <input type="text" class="form-control" id="title" v-model="archive.archive.title" placeholder="contoh: Surat Masuk dari PPTI" required>
                    </div>
                    <div class="form-group row">
                        <label for="title">Catatan Arsip</label>
                        <textarea id="note" v-model="archive.archive.note" class="form-control" cols="30" rows="5" placeholder="contoh: Proposal ini berada di dalam Map Kuning" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label>Unggah Arsip</label>
                        <input type="file" class="file-upload-default" v-on:change="onFileChange">
                        <div class="input-group col-xs-6">
                            <div class="input-group-append">
                                <button class="file-upload-browse btn btn-gradient btn-fw" type="button">Pilih File</button>                          
                            </div>
                            <input type="text" v-model="archive.archive.file" class="form-control file-upload-info" disabled placeholder="Hanya file gambar, microsoft office, dan pdf">
                        </div>
                        <small class="mt-2">Max: 3 MB</small>
                    </div>
                    <div class="alert alert-danger row" v-if="has_error">
                        <span>{{ validationErrors }}</span>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2 mt-4">Simpan</button>
                    <router-link :to="{ name:'archive_index' }" class="btn btn-light mt-4">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'archive_edit',
        data() {
            return {
                archive: {
                    archive: {
                        number: '',
                        title: '',
                        note: '',
                        category_id: '',
                        rack_id: '',
                        file: '',
                        c_rack: {
                            name: '',
                            c_room: {
                                name: ''
                            }
                        },
                        c_category: {
                            name: ''
                        }
                    },
                    rack: []
                },
                has_error: false,
                validationErrors: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/archiveapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.archive = response.data
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
            $('.file-upload-browse').on('click', function(){
                var file = $(this).parent().parent().parent().find('.file-upload-default')
                file.trigger('click')
            })
            $('.file-upload-default').on('change', function(){
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''))
            })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                let formData = new FormData()
                formData.append('category_id', this.archive.archive.category_id)
                formData.append('rack_id', this.archive.archive.rack_id)
                formData.append('number', this.archive.archive.number)
                formData.append('title', this.archive.archive.title)
                formData.append('note', this.archive.archive.note)
                formData.append('file', this.archive.archive.file)
                formData.append('_method', 'PATCH')
                axios.post('/api/archiveapi/' + this.$route.params.id, formData, config).then(response => {
                    if (response.data.status === "error") {
                        this.has_error = true
                        this.validationErrors = response.data.errors.file.join(', ')
                    }
                    else {
                        this.$router.push({name: 'archive_index'})
                        this.$swal({
                            title: 'Sukses!',
                            text: 'Data berhasil diubah',
                            type: 'success',
                        })
                    }
                })
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files
                if (!files.length)
                    return
                this.archive.archive.file = files[0]
            }
        }
    }
</script>
