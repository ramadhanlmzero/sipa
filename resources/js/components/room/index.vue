<template>
    <div>
        <div class="tombol">
            <router-link :to="{ name:'room_create' }" class="btn btn-gradient btn-fw">
                Tambah Data
            </router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Ruangan</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="roomTable" class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No.</th>
                                        <th>Kode</th>
                                        <th>Nama Ruangan</th>
                                        <th>Admin Ruangan</th>
                                        <th>Total Rak</th>
                                        <th>Total Arsip</th>
                                        <th width="80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, counter) in room" :key="counter" data-child-value="hidden 1">
                                        <td>{{ counter+1 }}</td>
                                        <td>{{ value.code }}</td>
                                        <td>{{ value.name }}</td>
                                        <td>{{ value.c_user.name }}</td>
                                        <td>{{ value.c_racks.length }}</td>
                                        <td>{{ value.c_archives.length }}</td>
                                        <td>
                                            <router-link :to="{ path:'/room/edit/'+value.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Data">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button type="submit" v-if="checkroom.includes(value.id)" v-on:click="blockDelete" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <button type="submit" v-else v-on:click="deleteEntry(value.id, counter)" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
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
    import $ from 'jquery'
    import dt from 'datatables.net-bs4'
    export default {
        name: 'room_index',
        data() {
			return {
                room: [],
                checkroom: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.roomTable).DataTable()
			axios.get('api/roomapi').then(response => {
				this.room = response.data
            })
			axios.get('api/checkroomapi').then(response => {
				this.checkroom = response.data
            })
        },
        watch: {
            room(val) {
                this.dt.destroy()
                this.$nextTick(() => {
                    this.dt = $(this.$refs.roomTable).DataTable({
                        "oLanguage": {
                            "sLengthMenu": "Tampilkan _MENU_ ruangan",
                            "sZeroRecords": "Belum ada ruangan apapun",
                            "sInfoEmpty": "Menampilkan 0 data",
                            "sInfoFiltered": "",
                            "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ ruangan",
                            "sSearch": "Cari: ",
                            "oPaginate": {
                                "sNext": "Selanjutnya",
                                "sPrevious": "Sebelumnya"
                            }
                        },
                        stateSave: true
                    })
                })
            }
        },
        methods: {
            deleteEntry(id, index) {
                this.$swal({
                    title: 'Yakin ingin menghapusnya?',
                    text: 'Anda tidak bisa membatalkannya bila sudah terhapus',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Tidak Jadi'
                }).then((result) => {
                    if(result.value) {
                        axios.delete('/api/roomapi/' + id).then(response => {
                            this.room.splice(index, 1)
                        })
                        this.dt.draw()
                        this.$swal('Sukses!', 'Data berhasil terhapus', 'success')
                    }
                })
            },
            blockDelete() {
                this.$swal('Gagal!', 'Data tidak terhapus karena ada rak yang berada di ruangan ini! Hapus rak tersebut atau ubah saja ruangan ini!', 'warning')
            }
        }
    }
</script>

<style>
    .btn i {
        margin-right: 0;
    }
</style>
