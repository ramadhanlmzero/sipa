<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Hak Akses</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="userTable" class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No.</th>
                                        <th>Nama</th>
                                        <th>Jenis Hak Akses</th>
                                        <th width="100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, counter) in user" :key="counter">
                                        <td>{{ counter+1 }}</td>
                                        <td>{{ value.name }}</td>
                                        <td>
                                            <span v-for="(item, counter) in value.c_roles" :key="counter">
                                                {{ item.type }}
                                                <span v-if="counter+1 < value.c_roles.length">, </span>
                                            </span>
                                        </td>
                                        <td>
                                            <router-link :to="{ path:'/userrole/edit/'+value.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Data">
                                                <i class="fa fa-pencil mr-1"></i>
                                                Ganti Hak Akses
                                            </router-link>
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
        name: 'userrole_index',
        data() {
			return {
                user: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.userTable).DataTable()
			axios.get('api/userroleapi').then(response => {
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
        }
    }
</script>
