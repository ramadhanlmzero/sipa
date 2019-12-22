<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Ubah Data {{ room.room.name }}</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="code">Kode Ruangan</label>
                        <input type="text" class="form-control" id="code" v-model="room.room.code" placeholder="contoh: A10.02.01" required maxlength="10">
                    </div>
                    <div class="form-group row">
                        <label for="name">Nama Ruangan</label>
                        <input type="text" class="form-control" id="name" v-model="room.room.name" placeholder="contoh: Ruang Tata Usaha" required>
                    </div>
                    <div class="form-group row">
                        <label>Admin Ruangan</label>
                        <select class="form-control" v-model="room.room.user_id" required>
                            <option :value="room.room.c_user.id" selected>{{ room.room.c_user.name }}</option>
                            <option v-for="(value, counter) in room.user" :key="counter" :value="value.id">{{ value.name }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'room_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'room_edit',
        data() {
            return {
                room: {
                    room: {
                        c_user: {}
                    },
                    user: {}
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/roomapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.room = response.data
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/roomapi/' + this.$route.params.id, this.room.room).then(response => {
                    this.$router.push({name: 'room_index'})
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
