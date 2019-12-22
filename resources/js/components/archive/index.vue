<template>
    <div>
        <div class="tombol">
            <router-link :to="{ name:'archive_create' }" class="btn btn-gradient btn-fw">
                Tambah Data
            </router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Arsip</h4>
                <h6>Filter</h6>
                <div class="row mb-3" id="filter">
                    <div class="col-xl-2 mt-2">
                        <small id="selectCategory">Filter Kategori</small>
                    </div>
                    <div class="col-xl-2 mt-2">
                        <small id="selectRack">Filter Rak</small>
                    </div>
                    <div class="col-xl-2 mt-2">
                        <small id="selectStatus">Filter Status</small>
                    </div>
                    <div class="col-xl-2 mt-2">
                        <small id="selectUser">Filter Pengunggah</small>
                    </div>
                    <div class="col-xl-2 mt-2">
                        <small id="selectYear">Filter Tahun</small>
                    </div>
                    <div class="col-xl-2 mt-2">
                        <small id="selectMonth">Filter Bulan</small>
                        <select id="month" class="form-control"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table ref="archiveTable" id="archiveTable" class="table">
                                <thead>
                                    <tr>
                                        <th>No. Arsip</th>
                                        <th>Judul Arsip</th>
                                        <th class="d-none"></th>
                                        <th class="d-none">ID Rak</th>
                                        <th>Kategori</th>
                                        <th>Diunggah oleh</th>
                                        <th>Status</th>
                                        <th class="d-none">Status</th>
                                        <th>File</th>
                                        <th class="d-none">Tanggal Dibuat</th>
                                        <th class="d-none">Tahun</th>
                                        <th class="d-none">Bulan</th>
                                        <th width="180px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, counter) in archive" :key="value.id">
                                        <td>{{ value.number }}</td>
                                        <td>{{ value.title }}</td>
                                        <td class="d-none"></td>
                                        <td class="d-none">{{ value.c_rack.id }}</td>
                                        <td>{{ value.c_category.name }}</td>
                                        <td>{{ value.c_user.name }}</td>
                                        <td>
                                            <div v-if="value.status === 'Sudah Dikonfirmasi'" class="badge badge-success badge-fw">
                                                Accepted
                                            </div>
                                            <div v-else class="badge badge-warning badge-fw">
                                                Not accepted
                                            </div>
                                        </td>
                                        <td class="d-none">{{ value.status }}</td>
                                        <td>
                                            <a :href="'storage/archive/' + value.file" target="_blank" class="btn btn-info mr-2 p-2" data-toggle="tooltip" title="Download file">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                        <td class="d-none"> {{ value.created_at }} </td>
                                        <td class="d-none"> {{ getYear(value.created_at) }} </td>
                                        <td class="d-none"> {{ getMonth(value.created_at) }} </td>
                                        <td>
                                        <template v-for="(item, index) in $auth.user().role">
                                                <button v-if="value.status === 'Belum Dikonfirmasi' && (item.type === 'Superadmin' || $auth.user().user.id === value.c_rack.c_room.user_id)" type="submit" v-on:click="confirm(value.id)" class="btn btn-success mr-2 p-2" data-toggle="tooltip" title="Konfirmasi status arsip">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <router-link v-if="value.status === 'Belum Dikonfirmasi' && $auth.user().user.id === value.c_user.id || item.type === 'Superadmin'" :to="{ path:'/archive/edit/'+value.id }" class="btn btn-primary mr-2 p-2" data-toggle="tooltip" title="Ubah Data">
                                                    <i class="fa fa-pencil"></i>
                                                </router-link>
                                                <button type="submit" v-if="value.status === 'Belum Dikonfirmasi' && $auth.user().user.id === value.c_user.id || item.type === 'Superadmin'" v-on:click="deleteEntry(value.id, counter)" class="btn btn-danger p-2" data-toggle="tooltip" title="Hapus Data">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                        </template>
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
    import moment from 'moment'
    export default {
        name: 'archive_index',
        data() {
			return {
                archive: [],
                rack: [],
                category: []
            }
        },
        mounted() {
            this.dt = $(this.$refs.archiveTable).DataTable()
			axios.get('api/archiveapi').then(response => {
                this.archive = response.data
            })
        },
        watch: {
            archive(val) {
                this.dt.destroy()
                this.$nextTick(() => {
                    this.dt = $(this.$refs.archiveTable).DataTable({
                        "oLanguage": {
                            "sLengthMenu": "Tampilkan _MENU_ arsip",
                            "sZeroRecords": "Belum ada arsip apapun",
                            "sInfoEmpty": "Menampilkan 0 data",
                            "sInfoFiltered": "",
                            "sInfo": "Menampilkan _START_ - _END_ dari _TOTAL_ arsip",
                            "sSearch": "Cari: ",
                            "oPaginate": {
                                "sNext": "Selanjutnya",
                                "sPrevious": "Sebelumnya"
                            }
                        },
                        stateSave: true,
                        "initComplete": function() {
                            var table = $('#archiveTable').DataTable()

                            var draw = table.draw()
                            if (draw) {
                                $('select#status').remove()
                                $('select#category').remove()
                                $('select#rack').remove()
                                $('select#user').remove()
                                $('select#year').remove()
                            }

                            var selectStatus = $('<select id="status" class="form-control"><option value="">Pilih Semua</option><option value="Sudah Dikonfirmasi">Sudah Dikonfirmasi</option><option value="Belum Dikonfirmasi">Belum Dikonfirmasi</option></select>')
                            .appendTo('#selectStatus')
                            .on('change', function() {
                                table.column(7).search(this.value).draw()
                            })

                            var state = table.state.loaded()
                            if (state) {
                                var valStatus = state.columns[7]
                                selectStatus.val(valStatus.search.search)
                            }

                            function getYear(value) {
                                moment.locale('id')
                                return moment(value).format('YYYY')
                            }

                            axios.get('api/dashboardapi').then(response => {
                                this.time = response.data

                                var html = ''

                                for (var i=0;i<this.time.year.length;i++) {
                                    var value = getYear(this.time.year[i])
                                    html += '<option value="' + value + '">' + value + '</option>'
                                }
                                
                                var selectYear = $('<select id="year" class="form-control"><option value="" selected>Pilih Semua</option></select>')
                                .appendTo('#selectYear')
                                .append(html)
                                .on('change', function() {
                                    table.column(11).search("").draw()
                                    table.column(10).search(this.value).draw()

                                    $('select#month option').remove()

                                    var htmlMonth = '<option value="" selected>Pilih Semua</option>'

                                    for (var i=1;i<13;i++) {
                                        var value = i
                                        htmlMonth += '<option value="' + value + '">' + value + '</option>'
                                    }

                                    var selectMonth = $('select#month')
                                    .append(htmlMonth)
                                    .on('change', function() {
                                        table.column(11).search(this.value).draw()
                                    })

                                    if(selectYear.val() == '') {
                                        $('select#month option').remove()
                                        table.column(11).search('').draw()
                                        table.state.clear()
                                    }
                                })

                                var state = table.state.loaded()
                                if (state) {
                                    var valYear = state.columns[10]
                                    selectYear.val(valYear.search.search)
                                }

                                if(selectYear.val() != '') {
                                    var htmlMonth = '<option value="" selected>Pilih Semua</option>'

                                    for (var i=1;i<13;i++) {
                                        var value = i
                                        htmlMonth += '<option value="' + value + '">' + value + '</option>'
                                    }

                                    var selectMonth = $('select#month')
                                    .append(htmlMonth)
                                    .on('change', function() {
                                        table.column(11).search("^"+this.value+"$", true, false).draw()
                                    })

                                    var state = table.state.loaded()
                                    if (state) {
                                        var valMonth = state.columns[11]
                                        selectMonth.val(valMonth.search.search)
                                    }
                                }
                            })

                            axios.get('api/categoryapi').then(response => {
                                this.category = response.data
                                var html = '' 
                                for (var i=0;i<this.category.length;i++) {
                                    var value = this.category[i].name
                                    html += '<option value="' + value + '">' + value + '</option>'
                                }
                                
                                var selectCategory = $('<select id="category" class="form-control"><option value="" selected>Pilih Semua</option></select>')
                                .appendTo('#selectCategory')
                                .append(html)
                                .on('change', function() {
                                    table.column(4).search(this.value).draw()
                                })

                                var state = table.state.loaded()
                                if (state) {
                                    var valCategory = state.columns[4]
                                    selectCategory.val(valCategory.search.search)
                                }
                            })

                            axios.get('api/rackapi').then(response => {
                                this.rack = response.data
                                var html = '' 
                                for (var i=0;i<this.rack.length;i++) {
                                    var value = this.rack[i].id
                                    var valueName = this.rack[i].name
                                    html += '<option value="' + value + '">' + valueName + '</option>'
                                }
                                
                                var selectRack = $('<select id="rack" class="form-control"><option value="" selected>Pilih Semua</option></select>')
                                .appendTo('#selectRack')
                                .append(html)
                                .on('change', function() {
                                    table.column(3).search(this.value).draw()
                                })

                                var state = table.state.loaded()
                                if (state) {
                                    var valRack = state.columns[3]
                                    selectRack.val(valRack.search.search)
                                }
                            })
                            
                            axios.get('api/userroleapi').then(response => {
                                this.user = response.data
                                var html = ''
                                for (var i=0;i<this.user.length;i++) {
                                    for (var j=0;j<this.user[i].c_roles.length;j++) {
                                        if (this.user[i].c_roles[j].type != 'Admin') {
                                            var value = this.user[i].name
                                            html += '<option value="' + value + '">' + value + '</option>'
                                        }
                                    }
                                }
                                
                                var selectUser = $('<select id="user" class="form-control"><option value="" selected>Pilih Semua</option></select>')
                                .appendTo('#selectUser')
                                .append(html)
                                .on('change', function() {
                                    table.column(5).search(this.value).draw()
                                })

                                var state = table.state.loaded()
                                if (state) {
                                    var valUser = state.columns[5]
                                    selectUser.val(valUser.search.search)
                                }
                            })
                        }
                    // })
                    }).order([9, 'desc']).draw()
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
                        axios.delete('/api/archiveapi/' + id).then(response => {
                            this.archive.splice(index, 1)
                            this.dt.draw()
                        })
                        this.$swal('Sukses!', 'Data berhasil terhapus', 'success')
                    }
                })
            },
            confirm(id, index) {
                axios.patch('/api/confirmarchiveapi/' + id).then(response => {
                    this.$swal({
                        title: 'Sukses!',
                        text: 'Arsip telah dikonfirmasi',
                        type: 'success',
                        showConfirmButton: false
                    })
                    setTimeout(function () {
                        window.location.reload()
                    }, 1000)
                })
            },
            getYear(value) {
                moment.locale('id')
                return moment(value).format('YYYY')
            },
            getMonth(value) {
                moment.locale('id')
                return moment(value).format('M')
            },
            getDate(value) {
                moment.locale('id')
                return moment(value).format('D')
            }
        }
    }
</script>
