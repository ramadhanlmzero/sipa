<template>
    <div>
        <div class="tombol">
            <router-link :to="{ name:'category_create' }" class="btn btn-gradient btn-fw">
                Tambah Data
            </router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Kategori</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="categoryTable" class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No.</th>
                                        <th>Kode</th>
                                        <th>Jenis Kategori</th>
                                        <th>Total Arsip</th>
                                        <th width="80px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, counter) in category" :key="counter" data-child-value="hidden 1">
                                        <td>{{ counter+1 }}</td>
                                        <td>{{ value.code }}</td>
                                        <td>{{ value.name }}</td>
                                        <td>{{ value.c_archives.length }}</td>
                                        <td>
                                            <router-link :to="{ path:'/category/edit/'+value.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Data">
                                                <i class="fa fa-pencil"></i>
                                            </router-link>
                                            <button type="submit" v-if="checkcategory.includes(value.id)" v-on:click="blockDelete" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
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
        name: 'category_index',
        data() {
			return {
                category: [],
                checkcategory: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.categoryTable).DataTable()
			axios.get('api/categoryapi').then(response => {
				this.category = response.data
            })
			axios.get('api/checkcategoryapi').then(response => {
				this.checkcategory = response.data
            })
        },
        watch: {
            category(val) {
                this.dt.destroy()
                this.$nextTick(() => {
                    this.dt = $(this.$refs.categoryTable).DataTable({
                        "oLanguage": {
                            "sLengthMenu": "Tampilkan _MENU_ kategori",
                            "sZeroRecords": "Belum ada kategori apapun",
                            "sInfoEmpty": "Menampilkan 0 data",
                            "sInfoFiltered": "",
                            "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ kategori",
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
                        axios.delete('/api/categoryapi/' + id).then(response => {
                            this.category.splice(index, 1)
                        })
                        this.dt.draw()
                        this.$swal('Sukses!', 'Data berhasil terhapus', 'success')
                    }
                })
            },
            blockDelete() {
                this.$swal('Gagal!', 'Data tidak terhapus karena ada arsip yang mengandung kategori ini! Hapus arsip tersebut atau ubah saja kategori ini!', 'warning')
            }
        }
    }
</script>

<style>
    .btn i {
        margin-right: 0;
    }
</style>
