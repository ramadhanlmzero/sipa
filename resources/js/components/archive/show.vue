<template>
    <div>
        <div class="tombol">
            <router-link :to="{ path:'/account/edit/'+$auth.user().user.id }" class="btn btn-gradient btn-fw mr-3">
                Perbarui Data Akun
            </router-link>
            <router-link :to="{ path:'/account/reset/'+$auth.user().user.id }" class="btn btn-warning btn-fw">
                Ubah Password
            </router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rincian Arsip {{ archive.title }}</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="300px">Nomor Arsip</th>
                                        <td>: {{ archive.number }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Judul Arsip</th>
                                        <td>: {{ archive.title }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Diunggah oleh </th>
                                        <td>: {{ archive.c_user.name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Kategori Arsip</th>
                                        <td>: {{ archive.c_category.name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Ruang Penyimpanan Arsip</th>
                                        <td>: {{ archive.c_rack.c_room.name }} (Admin: {{ archive.c_rack.c_room.c_user.name }})</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Rak Penyimpanan Arsip</th>
                                        <td>: {{ archive.c_rack.name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Status Arsip</th>
                                        <td>:
                                            <div v-if="archive.status === 'Sudah Dikonfirmasi'" class="badge badge-success badge-fw">
                                                Accepted
                                            </div>
                                            <div v-else class="badge badge-warning badge-fw">
                                                Not accepted
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Download Arsip</th>
                                        <td>:
                                            <a :href="'/storage/archive/' + archive.file" target="_blank" class="btn btn-info mr-2 p-2" data-toggle="tooltip" title="Download file">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Catatan</th>
                                        <td>: {{ archive.note }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Terakhir Diunggah</th>
                                        <td>: {{ parseDate(archive.created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Terakhir Diperbarui</th>
                                        <td>: {{ parseDate(archive.updated_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        name: 'archive_show',
        data() {
			return {
                archive: ''
            }
        },
        mounted() {
            axios.get('/api/archiveapi/' + this.$route.params.id)
            .then(response => {
                this.archive = response.data
                console.log(this.archive)
            }).catch(error => {
                this.$router.push({name: 'notfound'})
            })
        },
        methods: {
            parseDate(value) {
                moment.locale('id')
                return moment(value).format('D MMMM YYYY H:mm:ss')
            }
        }
    }
</script>
