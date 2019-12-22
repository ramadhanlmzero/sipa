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
                <h4 class="card-title">Data Akun Anda</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="300px">Nama</th>
                                        <td>: {{ $auth.user().user.name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Email</th>
                                        <td>: {{ $auth.user().user.email }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Bergabung Sejak</th>
                                        <td>: {{ parseDate($auth.user().user.created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Terakhir Memperbarui Data</th>
                                        <td>: {{ parseDate($auth.user().user.updated_at) }}</td>
                                    </tr>
                                    <tr>
                                        <th width="300px">Hak Akses</th>
                                        <td>: {{ $auth.user().role.type }}</td>
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
        name: 'account_index',
        methods: {
            parseDate(value) {
                moment.locale('id')
                return moment(value).format('D MMMM YYYY H:mm:ss')
            }
        }
    }
</script>
