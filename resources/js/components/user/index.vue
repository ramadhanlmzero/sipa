<template>
    <div>
        <div class="tombol">
            <router-link :to="{ name:'user_create' }" class="btn btn-gradient btn-fw">
                Tambah Data
            </router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data User</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="userTable" class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Total Arsip</th>
                                        <th width="100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, counter) in user" :key="counter">
                                        <td>{{ counter+1 }}</td>
                                        <td>{{ value.name }}</td>
                                        <td>{{ value.email }}</td>
                                        <td>{{ value.c_archives.length }}</td>
                                        <td>
                                            <router-link :to="{ path:'/user/edit/'+value.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Password">
                                                Reset
                                            </router-link>
                                            <button type="submit" v-on:click="deleteEntry(value.id, counter)" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus User">
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
        name: 'user_index',
        data() {
			return {
                user: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.userTable).DataTable()
			axios.get('api/userapi').then(response => {
				this.user = response.data
            })
        },
        watch: {
            user(val) {
                this.dt.destroy()
                this.$nextTick(() => {
                    this.dt = $(this.$refs.userTable).DataTable({
                        "oLanguage": {
                            "sLengthMenu": "Tampilkan _MENU_ user",
                            "sZeroRecords": "Belum ada user apapun",
                            "sInfoEmpty": "Menampilkan 0 data",
                            "sInfoFiltered": "",
                            "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ user",
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
                        axios.delete('/api/userapi/' + id).then(response => {
                            this.user.splice(index, 1)
                        })
                        this.dt.draw()
                        this.$swal('Sukses!', 'Data berhasil terhapus', 'success')
                    }
                })
            }
        }        
    }
</script>
