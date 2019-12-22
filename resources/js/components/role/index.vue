<template>
    <div>
        <div class="tombol">
            <router-link :to="{ name:'role_create' }" class="btn btn-gradient btn-fw">
                Tambah Data
            </router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Role</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="roleTable" class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No.</th>
                                        <th>Jenis Hak Akses</th>
                                        <th width="80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, counter) in role" :key="counter">
                                        <td>{{ counter+1 }}</td>
                                        <td>{{ value.type }}</td>
                                        <td>
                                            <router-link :to="{ path:'/role/edit/'+value.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Data">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button type="submit" v-on:click="deleteEntry(value.id, counter)" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
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
        name: 'role_index',
        data() {
			return {
                role: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.roleTable).DataTable()
			axios.get('api/roleapi').then(response => {
				this.role = response.data
            })
        },
        watch: {
            role(val) {
                this.dt.destroy()
                this.$nextTick(() => {
                    this.dt = $(this.$refs.roleTable).DataTable({
                        "oLanguage": {
                            "sLengthMenu": "Tampilkan _MENU_ role",
                            "sZeroRecords": "Belum ada role apapun",
                            "sInfoEmpty": "Menampilkan 0 data",
                            "sInfoFiltered": "",
                            "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ role",
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
                        axios.delete('/api/roleapi/' + id).then(response => {
                            this.role.splice(index, 1)
                        })
                        this.dt.draw()
                        this.$swal('Sukses!', 'Data berhasil terhapus', 'success')
                    }
                })
            }
        }
    }
</script>

<style>
    .tombol {
        margin-bottom: 20px;
    }
    .btn-gradient{
        background: #13b4ca;   
        color: white;
    }
    .tombol a:hover {  
        color: white;
    }
</style>

