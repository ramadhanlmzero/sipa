<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Input Data Ruangan</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label for="code">Kode Ruangan</label>
                        <input type="text" class="form-control" id="code" v-model="room.code" placeholder="contoh: A10.02.01" required maxlength="10">
                    </div>
                    <div class="form-group row">
                        <label for="name">Nama Ruangan</label>
                        <input type="text" class="form-control" id="name" v-model="room.name" placeholder="contoh: Ruang Tata Usaha" required>
                    </div>
                    <div class="form-group row">
                        <label>Admin Ruangan</label>
                        <select class="form-control" v-model="room.user_id" required>
                            <option value="" disabled selected>Pilih salah satu</option>
                            <option v-for="(value, counter) in user" :key="counter" :value="value.id">{{ value.name }}</option>
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
        name: 'room_create',
        data() {
            return {
                room: {
                    user_id: ''
                },
                user: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/userapi').then(response => {
                this.user = response.data
            })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.post('/api/roomapi', this.room).then(response => {
                    this.$router.push({name: 'room_index'})
                    this.$swal({
                        title: 'Sukses!',
                        text: 'Data berhasil dimasukkan',
                        type: 'success',
                    })
                })
            }
        }
    }
</script>
