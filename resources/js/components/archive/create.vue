<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Input Data Arsip</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label>Kategori</label>
                        <select class="form-control" v-model="selectedCategory" v-on:change="generateCat">
                            <option value="" disabled selected>Pilih salah satu</option>
                            <option v-for="(value, counter) in category" :key="counter" :value="value.id+'|'+value.code+'|'+value.number">{{ value.name }}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label>Ruangan</label>
                        <select class="form-control" v-model="room_id" v-on:change="selectedRoom()">
                            <option value="" disabled selected>Pilih salah satu</option>
                            <option v-for="(value, counter) in room" :key="counter" :value="value.id">{{ value.name }}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label>Rak Penyimpanan</label>
                        <select class="form-control" v-model="archive.rack_id">
                            <option value="" disabled selected>Pilih salah satu</option>
                            <option v-for="(value, counter) in rack.c_racks" :key="counter" :value="value.id">{{ value.name }}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="number">Nomor Arsip</label>
                        <input type="text" class="form-control" id="number" v-model="archive.number" readonly required>
                        <small class="text-muted">Terisi otomatis ketika kategori sudah dipilih</small>
                    </div>
                    <div class="form-group row">
                        <label for="title">Judul Arsip</label>
                        <input type="text" class="form-control" id="title" v-model="archive.title" placeholder="contoh: Proposal Pengajuan Dana" required>
                    </div>
                    <div class="form-group row">
                        <label for="title">Catatan Arsip</label>
                        <textarea id="note" v-model="archive.note" class="form-control" cols="30" rows="5" placeholder="contoh: Proposal ini berada di dalam Map Kuning" required></textarea>
                    </div>
                    <div class="form-group row">
                        <label>Unggah Arsip</label>
                        <input type="file" class="file-upload-default" v-on:change="onFileChange">
                        <div class="input-group col-xs-6">
                            <div class="input-group-append">
                                <button class="file-upload-browse btn btn-gradient btn-fw" type="button">Pilih File</button>                          
                            </div>
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Hanya file gambar, microsoft office, dan pdf">
                        </div>
                        <small class="mt-2">Max: 3 MB</small>
                    </div>
                    <div class="alert alert-danger" v-if="has_error">
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
    import moment from 'moment'
    export default {
        name: 'archive_create',
        data() {
            return {
                archive: {
                    number: '',
                    title: '',
                    category_id: '',
                    rack_id: '',
                    file: ''
                },
                has_error: false,
                validationErrors: '',
                year: moment().format('YYYY'),
                month: moment().format('MM'),
                day: moment().format('DD'),
                selectedCategory: '',
                room_id: '',
                rack: [],
                category: [],
                room: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/categoryapi').then(response => {
                this.category = response.data
            })
            axios.get('/api/roomapi').then(response => {
                this.room = response.data
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
                formData.append('category_id', this.archive.category_id)
                formData.append('rack_id', this.archive.rack_id)
                formData.append('number', this.archive.number)
                formData.append('title', this.archive.title)
                formData.append('file', this.archive.file)
                formData.append('note', this.archive.note)
                axios.post('/api/archiveapi', formData, config).then(response => {
                    if (response.data.status === "error") {
                        this.has_error = true
                        var validation = []
                        if (response.data.errors.category_id)
                        this.validationErrors = response.data.errors.category_id.join()
                        else if (response.data.errors.rack_id)
                        this.validationErrors = response.data.errors.rack_id.join()
                        else if (response.data.errors.file)
                        this.validationErrors = response.data.errors.file.join(' ,')
                    }
                    else {
                        this.$router.push({name: 'archive_index'})
                        this.$swal({
                            title: 'Sukses!',
                            text: 'Data berhasil dimasukkan',
                            type: 'success',
                        })
                    }
                    console.log(response.data.errors)
                })
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files
                if (!files.length)
                    return
                this.archive.file = files[0]
            },
            generateCat() {
                var code = this.selectedCategory
                code = code.split('|')
                this.archive.number = code[1] + '/' + this.year + '/' + this.month + '/' + this.day + '/' + (parseInt(code[2])+1)
                this.archive.category_id = code[0]
            },
            selectedRoom() {
                axios.get('/api/rackinroomapi/' + this.room_id).then(response => {
                    this.rack = response.data
                })
            }
        }
    }
</script>
