<template>
    <div>
        <div class="tombol">
            <router-link :to="{ name:'rack_create' }" class="btn btn-gradient btn-fw">
                Tambah Data
            </router-link>
        </div>
        <div class="card mb-4" v-for="(room, index) in rooms" :key="index">
            <div class="card-body">
                <h4 class="card-title">Data Rak di {{ room.name }}</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="rackTable" class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No.</th>
                                        <th>Nama Rak</th>
                                        <th>Total Arsip</th>
                                        <th width="80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(rack, counter) in room.c_racks" :key="counter">
                                        <td>{{ counter+1 }}</td>
                                        <td>{{ rack.name }}</td>
                                        <td>{{ rack.c_archives.length }}</td>
                                        <td>
                                            <router-link :to="{ path:'/rack/edit/'+rack.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Data">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button type="submit" v-if="checkrack.includes(rack.id)" v-on:click="blockDelete" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <button type="submit" v-else v-on:click="deleteEntry(rack.id, counter)" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
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
        name: 'rack_index',
        data() {
			return {
                racks: [],
                checkrack: [],
                rooms: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.rackTable).DataTable()
			axios.get('api/rackapi').then(response => {
                this.racks = response.data
            })
            axios.get('api/checkrackapi').then(response => {
                this.checkrack = response.data
            })
            axios.get('api/roomapi').then(response => {
                this.rooms = response.data
            })
        },
        watch: {
            rooms(val) {
                this.dt.destroy()
                this.$nextTick(() => {
                    this.dt = $(this.$refs.rackTable).DataTable({
                        "oLanguage": {
                            "sLengthMenu": "Tampilkan _MENU_ rak",
                            "sZeroRecords": "Belum ada rak apapun",
                            "sInfoEmpty": "Menampilkan 0 data",
                            "sInfoFiltered": "",
                            "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ rak",
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
                        axios.delete('/api/rackapi/' + id).then(response => {
                            this.racks.splice(index, 1)
                        })
                        this.dt.draw()
                        this.$swal({
                            title: 'Sukses!',
                            text: 'Data berhasil terhapus',
                            type: 'success',
                            showConfirmButton: false
                        })
                        setTimeout(function () {
                            window.location.reload()
                        }, 1000)
                    }
                })
            },
            blockDelete() {
                this.$swal('Gagal!', 'Data tidak terhapus karena ada arsip yang mengandung rak ini! Hapus arsip tersebut atau ubah saja rak ini!', 'warning')
            },
            blockAccess() {
                this.$swal('Gagal!', 'Anda tidak bisa menghapus rak ini karena bukan anda yang menginputnya!', 'warning')
            }
        }
    }
</script>
