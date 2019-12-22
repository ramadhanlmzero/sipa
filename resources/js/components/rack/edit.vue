<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 row">Ubah Data {{ rack.rack.name }}</h4>
                <form v-on:submit="saveForm()" class="forms-sample">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group row">
                        <label>Nama Ruangan</label>
                        <select class="form-control" v-model="rack.rack.room_id" required>
                            <option :value="rack.rack.c_room.id" selected>{{ rack.rack.c_room.name }}</option>
                            <option v-for="(room, counter) in rack.room" :key="counter" :value="room.id">{{ room.name }}</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="name">Nama Rak</label>
                        <input type="text" class="form-control" id="name" v-model="rack.rack.name" placeholder="contoh: rak A" required>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="slot">Slot Tersedia</label>
                        <input type="number" class="form-control" id="slot" v-model="rack.rack.slot" placeholder="contoh: 10" required>
                    </div> -->
                    <button type="submit" class="btn btn-gradient mr-2">Simpan</button>
                    <router-link :to="{ name:'rack_index' }" class="btn btn-light">
                        Batal
                    </router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'rack_edit',
        data() {
            return {
                rack: {
                    rack: {
                        c_room: {}
                    },
                    room: {}
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        mounted() {
            axios.get('/api/rackapi/' + this.$route.params.id + '/edit')
                .then(response => {
                    this.rack = response.data
                }).catch(error => {
                    this.$router.push({name: 'notfound'})
                })
        },
        methods: {
            saveForm() {
                event.preventDefault()
                axios.patch('/api/rackapi/' + this.$route.params.id, this.rack.rack).then(response => {
                    this.$router.push({name: 'rack_index'})
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
