<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Ubah Hak Akses {{ userrole.user.name }}</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="type">Nama</label>
                        <input type="text" class="form-control" id="type" v-model="userrole.user.name" placeholder="contoh: admin" readonly>
                    </div>
                    <div class="form-group row2 pt-3">
                        <label>Jenis Hak Akses</label>
                        <div class="icheck-peterriver" v-for="(value, counter) in userrole.roleother" :key="counter">
                            <input type="checkbox" :id="value.id" :value="value.id" v-model="checkedRoles"/>
                            <label :for="value.id">{{ value.type }}</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'userrole_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'userrole_edit',
        data() {
            return {
                userrole: {
                    user: {
                        id: '',
                        name: ''
                    },
                    role: {
                        id: '',
                        type: ''
                    }
                },
                checkedRoles: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/userroleapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.userrole = response.data
                    this.userrole.user.c_roles.forEach(element => {
                        this.checkedRoles.push(element.id)
                    })
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/userroleapi/' + this.$route.params.id, this.checkedRoles).then(response => {
                    this.$router.push({name: 'userrole_index'})
                    this.$swal({
                        title: 'Sukses!',
                        text: 'Data berhasil diubah',
                        type: 'success',
                    })
                })
            }
        }
    }
</script>

<style scoped>
    .row2 {
        margin-right: -10px;
        margin-left: -10px;
    }
    /* .form-check {
        padding-left: 20px;
        margin-top: 0;
    }
    .form-check .form-check-label {
        padding-left: 0;
    }
    .labelkebawah {
        display: inline-block;
    } */
</style>
