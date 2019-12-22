<template>
    <div>
        <div class="row">
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="icon-user icon-lg text-success"></i>
                            <div class="ml-3">
                                <p class="mb-0">Jumlah User</p>
                                <h6>{{ dashboard.user }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="icon-notebook icon-lg text-warning"></i>
                            <div class="ml-3">
                                <p class="mb-0">Jumlah Arsip</p>
                                <h6>{{ dashboard.archive }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="icon-layers icon-lg text-info"></i>
                            <div class="ml-3">
                                <p class="mb-0">Jumlah Kategori</p>
                                <h6>{{ dashboard.category }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-md-center">
                            <i class="icon-social-dropbox icon-lg text-danger"></i>
                            <div class="ml-3">
                                <p class="mb-0">Jumlah Rak</p>
                                <h6>{{ dashboard.rack }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Aktivitas Pengunggahan Arsip</h4>
                        </div>
                        <p v-if="dashboard.activity_create" class="card-description">{{ dashboard.log.length }} aktivitas unggah arsip terakhir</p>
                        <p v-else class="card-description">Tidak ada aktivitas apapun</p>
                        <div class="list d-flex align-items-center border-bottom py-3" v-for="(value, counter) in dashboard.log" :key="counter">
                            <img class="img-sm rounded-circle" src="/assets/images/admin-pic.png">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0"><b>{{ value.c_user.name }} </b>mengunggah arsip "{{ value.title }}"</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-clock text-muted mr-1"></i>
                                        <p class="mb-0">{{ parseTime(value.created_at) }}</p>
                                    </div>
                                    <small class="text-muted ml-auto">{{ parseDate(value.created_at) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Notifikasi untuk Anda</h4>
                        </div>
                        <template v-if="dashboard.notification">
                            <p v-if="dashboard.notification.length > 0" class="card-description">Top 5 notifikasi untuk anda</p>
                            <p v-else class="card-description">Tidak ada notifikasi apapun</p>
                        </template>
                        <div v-for="(value, counter) in dashboard.notification" :key="counter">
                            <div v-for="(rack, counter2) in value.c_racks" :key="counter2">
                                <div class="list d-flex align-items-center border-bottom py-3" v-for="(archive, counter3) in rack.c_archives" :key="counter3">
                                    <img class="img-sm rounded-circle" src="/assets/images/admin-pic.png">
                                    <div class="wrapper w-100 ml-3">
                                        <p class="mb-0"><b>{{ archive.c_user.name }} </b>memasukkan arsip ke ruang {{ value.name }} anda</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-clock text-muted mr-1"></i>
                                                <p class="mb-0">{{ parseTime(archive.updated_at) }}</p>
                                            </div>
                                            <small class="text-muted ml-auto">{{ parseDate(archive.updated_at) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body" id="canvasCategory">
                        <h4 class="card-title">Grafik Arsip per Kategori</h4>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body" id="canvasRack">
                        <h4 class="card-title">Grafik Arsip per Rak</h4>
                        <canvas id="rackChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="$auth.user().role.type === 'Admin'">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body pb-0">
                        <h4 class="card-title">Petugas dengan Input Arsip Terbanyak</h4>
                        <div class="row">
                            <div class="col-12" v-for="(value, counter) in dashboard.active" :key="counter">
                                <div class="wrapper border-bottom py-2">
                                    <div class="d-flex">
                                        <img class="img-sm rounded-circle" src="/assets/images/admin-pic.png">
                                        <div class="wrapper ml-4">
                                            <p class="mb-0">{{ value.name }}</p>
                                            <small class="text-muted mb-0">Petugas</small>
                                        </div>
                                        <div class="rating ml-auto d-flex align-items-center">
                                            <p class="font-weight-medium mb-0">{{ value.c_archives_count }} Arsip</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card">
                <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Arsip Telah Terkonfirmasi</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-inline-block pt-3">
                                        <div class="d-lg-flex">
                                            <h2 class="mb-0">{{ dashboard.status_true }}</h2>
                                        </div>
                                        <small class="text-gray" v-if="dashboard.timestamp_true">Update terakhir: {{ parseDate2(dashboard.timestamp_true.updated_at) }}</small>
                                        <small class="text-gray" v-else>Tidak ada arsip dengan status sudah terkonfirmasi</small>
                                    </div>
                                    <div class="d-inline-block">
                                        <div class="bg-success px-3 px-md-4 py-2 rounded">
                                            <i class="fa fa-check text-white icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Arsip Belum Terkonfirmasi</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-inline-block pt-3">
                                        <div class="d-lg-flex">
                                            <h2 class="mb-0">{{ dashboard.status_false }}</h2>
                                        </div>
                                        <small class="text-gray" v-if="dashboard.timestamp_false">Update terakhir: {{ parseDate2(dashboard.timestamp_false.updated_at) }}</small>
                                        <small class="text-gray" v-else>Tidak ada arsip dengan status belum terkonfirmasi</small>
                                    </div>
                                    <div class="d-inline-block">
                                        <div class="bg-warning px-3 px-md-4 py-2 rounded">
                                            <i class="fa fa-times px-1 text-white icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Grafik Arsip Tiap Tahun</h4>
                        <p class="card-description">Pantau arsip tiap tahun untuk mengetahui performa pengarsipan di Jurusan Teknik Informatika Unesa</p>
                        <div class="col-xl-2 pull-right">
                            <small id="selectYear">Pilih Tahun</small>
                            <select id="year" class="form-control" v-model="selectedYear" v-on:change="year">
                                <option v-for="(value, counter) in dashboard.year" :key="counter" :value="value.year">{{ value.year }}</option>
                            </select>
                        </div>
                        <div id="canvasChart">
                            <canvas id="archiveChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js'
    import moment from 'moment'
    export default {
        name: 'dashboard',
        data() {
			return {
                dashboard: [],
                selectedYear: '',
                interval: '',
                intervalChart: ''
            }
        },
        mounted() {
            this.loadData()
            this.interval = setInterval(function () {
                this.loadData()
            }.bind(this), 10000)
            this.intervalChart = setInterval(function () {
                $('#categoryChart').remove()
                $('#canvasCategory').append('<canvas id="categoryChart" ><canvas>')
                this.categoryChart()
                $('#rackChart').remove()
                $('#canvasRack').append('<canvas id="rackChart" ><canvas>')
                this.rackChart()
                $('#archiveChart').remove()
                $('#canvasChart').append('<canvas id="archiveChart" ><canvas>')
                this.archiveChart(this.selectedYear)
            }.bind(this), 100000)
            moment.locale('id')
            this.selectedYear = moment().format('YYYY')
            this.categoryChart()
            this.rackChart()
            this.archiveChart(this.selectedYear)
        },
        beforeDestroy() {
            clearInterval(this.interval)
            clearInterval(this.intervalChart)
        },
        methods: {
            categoryChart() {
                axios.get('api/chartapi').then(response => {
                    this.category = response.data
                    var ctx = document.getElementById('categoryChart')
                    ctx.height = 220
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: this.category.category.name,
                            datasets: [{
                                label: 'Jumlah Arsip',
                                data: this.category.category.total,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'top',
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Kategori'
                                    }
                                },{
                                    display: true,
                                    gridLines: {display: false,color: 'transparent'},
                                    ticks: {display: false},
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'SIPA UNESA'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Jumlah'
                                    }
                                }]
                            }
                        }
                    })
                })
            },
            rackChart() {
                axios.get('api/chartapi').then(response => {
                    this.rack = response.data
                    var ctx = document.getElementById('rackChart')
                    ctx.height = 220
                    var myChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: this.rack.rack.name,
                            datasets: [{
                                label: 'Jumlah Arsip',
                                data: this.rack.rack.total,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255,99,132,1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'top',
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Total'
                                    }
                                },{
                                    display: true,
                                    gridLines: {display: false,color: 'transparent'},
                                    ticks: {display: false},
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'SIPA UNESA'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Rak'
                                    }
                                }]
                            }
                        }
                    })
                })
            },
            archiveChart(value) {
                axios.get('api/chart2api/' + value).then(response => {
                    this.archive = response.data
                    var ctx = document.getElementById('archiveChart')
                    ctx.height = 110
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            datasets: [{
                                label: 'Jumlah Arsip',
                                data: this.archive,
                                backgroundColor: 'rgba(171, 140 ,228, 0.7)',
                                borderColor: 'rgba(171, 140 ,228, 1)',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'top',
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Bulan'
                                    }
                                },{
                                    display: true,
                                    gridLines: {display: false,color: 'transparent'},
                                    ticks: {display: false},
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'SIPA UNESA'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Total'
                                    }
                                }]
                            }
                        }
                    })
                })
            },
            parseDate(value) {
                moment.locale('id')
                return moment(value).format('D MMMM YYYY')
            },
            parseDate2(value) {
                moment.locale('id')
                return moment(value).format('D MMMM YYYY H:mm')
            },
            parseTime(value) {
                moment.locale('id')
                return moment(value).format('H:mm')
            },
            year() {
                $('#archiveChart').remove()
                $('#canvasChart').append('<canvas id="archiveChart" ><canvas>')
                this.archiveChart(this.selectedYear)
            },
            loadData() {
                axios.get('api/dashboardapi').then(response => {
                    this.dashboard = response.data
                })
            }
        }
    }
</script>