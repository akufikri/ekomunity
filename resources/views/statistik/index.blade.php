<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistik</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landingpage/') }}/images/logo-usia.png">

    <link rel="stylesheet" href="{{ asset('template_dashboard/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet"
        href="{{ asset('template_dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template_dashboard/dist/css/adminlte.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/template_dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Mengatur agar gambar latar belakang selalu memenuhi lebar dan tinggi */
        .hero-section {
            width: 100%;
            overflow: hidden;
            position: relative;
            height: 35vh; /* Bisa disesuaikan sesuai kebutuhan */
        }

        .hero-section img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Memastikan gambar mengisi area tanpa terdistorsi */
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Mengatur ukuran chart agar responsif */
        .card-body canvas {
            width: 100% !important;
            height: auto !important; /* Biarkan tinggi menyesuaikan proporsi */
        }

        /* Border untuk card */
        .card-border {
            border: 1px solid #dee2e6; /* Contoh border, bisa disesuaikan */
            border-radius: .25rem; /* Sudut membulat */
            margin-bottom: 1rem; /* Jarak antar card */
        }

        /* Penyesuaian untuk tampilan mobile pada card TOTAL KEAHLIAN USIA */
        @media (max-width: 767.98px) {
            .card-body.total-keahlian {
                flex-direction: column; /* Ubah tata letak menjadi kolom */
                align-items: flex-start !important; /* Ratakan ke kiri */
            }
            .card-body.total-keahlian > div {
                margin-bottom: 10px; /* Jarak antar elemen */
            }
        }
    </style>
</head>

<body class="">
    <div class="hero-section">
        <img src="{{ asset('landingpage/images/main-slider/slide.jpeg') }}" alt="Background Image">
    </div>
    <section class="container mt-5">
        <div class="card card-border">
            <div class="card-body total-keahlian"
                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div style="flex: 1;">
                    <p>TOTAL KEAHLIAN USIA</p>
                    <h4 class="font-weight-bold">14812</h4>
                </div>
                <div style="flex-shrink: 0;">
                    <img src="https://datappk.com/assets/images/logo/people-community.svg" alt="People Community Icon">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4"> <div class="card card-border">
                    <div class="card-header bg-white border-0">
                        <h5 class="">Jantina</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chart-jantina"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card card-border">
                    <div class="card-header bg-white border-0">
                        <h5 class="">Bangsa</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chart-bangsa"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card card-border">
                    <div class="card-header bg-white border-0">
                        <h5 class="">Marital Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chart-maritial-status"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card card-border">
                    <div class="card-header bg-white border-0">
                        <h5 class="">Kisaran Umur</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="chart-kisaran-umur"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery.form.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script src="/template_dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/template_dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('template_dashboard/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('template_dashboard/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('template_dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="/js/my-custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script type="text/javascript" src="/js/config-firebase.js"></script>
    <script>
        $(document).ready(function() {
            let chartPendapatanInstance = null;
            $.ajax({
                url: 'https://login.datappk.com/api/projectionDataAhli',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    const weekly = res.total_income_ahli.weekly;

                    const fullLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep',
                        'Okt', 'Nov', 'Dis'
                    ];

                    // Ambil bulan sekarang (0 = Jan, 5 = Jun)
                    const currentMonthIndex = new Date().getMonth();

                    const labels = fullLabels; // tampilkan semua bulan

                    const colorMap = {
                        'DIBAWAH RM100': '#0A6375',
                        'RM100 - RM500': '#F26722',
                        'DIATAS RM500': '#F6BE00'
                    };

                    const datasets = weekly.map(item => {
                        const data = [];
                        for (let i = 0; i < 12; i++) {
                            data.push(i <= currentMonthIndex ? item.total : null);
                        }
                        return {
                            label: item.label,
                            data: data,
                            borderColor: colorMap[item.label] || '#999',
                            backgroundColor: colorMap[item.label] || '#999',
                            tension: 0.4,
                            fill: false,
                            pointBackgroundColor: colorMap[item.label] || '#999',
                            pointRadius: 6
                        };
                    });

                    // Pastikan chart-pendapatan ada di HTML jika ingin menampilkannya
                    // const ctx = $('#chart-pendapatan')[0].getContext('2d');

                    // new Chart(ctx, {
                    //     type: 'line',
                    //     data: {
                    //         labels: labels,
                    //         datasets: datasets
                    //     },
                    //     options: {
                    //         responsive: true,
                    //         plugins: {
                    //             legend: {
                    //                 display: true,
                    //                 labels: {
                    //                     usePointStyle: true,
                    //                     pointStyle: 'circle',
                    //                     padding: 20
                    //                 }
                    //             }
                    //         },
                    //         scales: {
                    //             y: {
                    //                 beginAtZero: true,
                    //                 suggestedMax: 20,
                    //                 ticks: {
                    //                     callback: function(value) {
                    //                         return value.toLocaleString();
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     }
                    // });
                },
                error: function(xhr, status, error) {
                    console.error('Gagal ambil data dari API:', error);
                }
            });

            function createDoughnutChart(selector, labels, data, backgroundColors) {
                new Chart($(selector), {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true, // Ubah menjadi true untuk responsif
                        maintainAspectRatio: false, // Penting untuk Chart.js agar responsif
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'rect',
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}`;
                                    }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }

            function fetchAndRenderBusinessType() {
                $.ajax({
                    type: "GET",
                    url: "https://login.datappk.com/api/projectionDataBusinessType",
                    dataType: "JSON",
                    success: function(res) {
                        const rawData = res.business_type || [];

                        const labels = rawData.map(item =>
                            `${item.business_type} (${item.percentage_label})`);
                        const data = rawData.map(item => item.percentage_value);
                        const colors = generateColorArray(data.length);

                        // chart-lesen-peniagaan tidak ada di HTML yang diberikan, jadi saya komentari
                        // createDoughnutChart('#chart-lesen-peniagaan', labels, data, colors);
                    },
                    error: function(err) {
                        console.error("Gagal load business_type:", err);
                    }
                });
            }

            function generateColorArray(length) {
                const palette = ['#1C7897', '#ED6B2C', '#F2BE3E', '#8EC3F5', '#E484B9', '#6FE6B5', '#F6DC8C',
                    '#B78DDC', '#E8A06C', '#E78A89'
                ];
                return [...Array(length)].map((_, i) => palette[i % palette.length]);
            }
            fetchAndRenderBusinessType();

            function fetchAndRenderGender() {
                $.ajax({
                    type: "GET",
                    url: "https://login.datappk.com/api/projectionDataGender",
                    dataType: "JSON",
                    success: function(res) {
                        const rawData = res.gender || [];

                        const labels = rawData.map(item => `${item.gender} (${item.percentage_label})`);
                        const data = rawData.map(item => item.percentage_value);
                        const colors = rawData.map(item => {
                            return item.gender.toLowerCase() === 'perempuan' ? '#D13F9FB2' :
                                '#589BDAB2';
                        });

                        createDoughnutChart('#chart-jantina', labels, data, colors);
                    },
                    error: function(err) {
                        console.error("Gagal load gender:", err);
                    }
                });
            }

            fetchAndRenderGender();

            function fetchAndRenderNation() {
                $.ajax({
                    type: "GET",
                    url: "https://login.datappk.com/api/projectionDataNation",
                    dataType: "JSON",
                    success: function(res) {
                        const rawData = res.nation || [];

                        // Ambil yang persentasenya > 0
                        const nonZero = rawData.filter(item => item.percentage_value > 0);

                        // Urutkan dari yang terbesar
                        const sorted = nonZero.sort((a, b) => b.percentage_value - a.percentage_value);

                        // Ambil 4 teratas
                        const top4 = sorted.slice(0, 4);

                        // Sisanya dijumlah
                        const others = sorted.slice(4);
                        const othersTotal = others.reduce((sum, item) => sum + item.percentage_value,
                            0);

                        // Gabungkan ke array akhir
                        const finalData = [...top4];
                        if (othersTotal > 0) {
                            finalData.push({
                                nation: 'Lainnya',
                                percentage_value: othersTotal,
                                percentage_label: `${othersTotal.toFixed(2)}%`
                            });
                        }

                        // Buat data untuk chart
                        const labels = finalData.map(item =>
                            `${item.nation} (${item.percentage_label})`);
                        const data = finalData.map(item => item.percentage_value);
                        const colors = generateColorArray(data.length);

                        createDoughnutChart('#chart-bangsa', labels, data, colors);
                    },
                    error: function(err) {
                        console.error("Gagal load nation:", err);
                    }
                });
            }

            fetchAndRenderNation()

            function fetchAndRenderMaritalStatus() {
                $.ajax({
                    type: "GET",
                    url: "https://login.datappk.com/api/projectionDataMarital",
                    dataType: "JSON",
                    success: function(res) {
                        const rawData = res.marital || [];

                        const filtered = rawData.filter(item => item.percentage_value > 0);
                        const labels = filtered.map(item =>
                            `${item.marital_status} (${item.percentage_label})`);
                        const data = filtered.map(item => item.percentage_value);
                        const colors = generateColorArray(data.length);

                        createDoughnutChart('#chart-maritial-status', labels, data, colors);
                    },
                    error: function(err) {
                        console.error("Gagal load marital status:", err);
                    }
                });
            }
            fetchAndRenderMaritalStatus();

            function fetchAndRenderAgeRange() {
                $.ajax({
                    type: "GET",
                    url: "https://login.datappk.com/api/projectionDataAge",
                    dataType: "JSON",
                    success: function(res) {
                        const rawData = res.age || [];

                        const filtered = rawData.filter(item => item.percentage > 0);
                        const labels = filtered.map(item => `${item.label} (${item.percentage_label})`);
                        const data = filtered.map(item => item.percentage);
                        const colors = generateColorArray(data.length);

                        createDoughnutChart('#chart-kisaran-umur', labels, data, colors);
                    },
                    error: function(err) {
                        console.error("Gagal load data umur:", err);
                    }
                });
            }
            fetchAndRenderAgeRange()

            function fetchAndRenderBusinessActivity() {
                $.ajax({
                    type: "GET",
                    url: "https://login.datappk.com/api/projectionDataBusinessActivity",
                    dataType: "JSON",
                    success: function(res) {
                        const rawData = res.business_activity || [];

                        // Filter hanya total > 0 lalu urutkan desc
                        const sorted = rawData
                            .filter(item => item.total > 0)
                            .sort((a, b) => b.total - a.total);

                        const topSix = sorted.slice(0, 6);
                        const remaining = sorted.slice(6);

                        // Jumlahkan total dari sisanya
                        const othersTotal = remaining.reduce((sum, item) => sum + item.total, 0);

                        const labels = topSix.map(item => item.business_activity);
                        const data = topSix.map(item => item.total);

                        if (othersTotal > 0) {
                            labels.push("Lainnya");
                            data.push(othersTotal);
                        }

                        const colors = generateColorArray(data.length);

                        // chart-aktiviti-peniagaan tidak ada di HTML yang diberikan, jadi saya komentari
                        // new Chart($('#chart-aktiviti-peniagaan'), {
                        //     type: 'bar',
                        //     data: {
                        //         labels: labels,
                        //         datasets: [{
                        //             label: 'Jumlah Aktiviti',
                        //             data: data,
                        //             backgroundColor: colors,
                        //             borderWidth: 0
                        //         }]
                        //     },
                        //     options: {
                        //         responsive: true,
                        //         plugins: {
                        //             legend: {
                        //                 display: false
                        //             }
                        //         },
                        //         scales: {
                        //             y: {
                        //                 beginAtZero: true,
                        //                 ticks: {
                        //                     callback: function(value) {
                        //                         return value.toLocaleString();
                        //                     }
                        //                 }
                        //             }
                        //         }
                        //     }
                        // });
                    },
                    error: function(err) {
                        console.error("Gagal load data aktiviti perniagaan:", err);
                    }
                });
            }

            fetchAndRenderBusinessActivity()

            $.ajax({
                type: "GET",
                url: "https://login.datappk.com/api/projectionDataAhli",
                dataType: "JSON",
                success: function(res) {
                    $('#total_ahli_overall').text(res.total_ahli_overall ?? '0');
                    $('#total_ahli_perniaga_se').text(res.total_ahli_perniaga_se ?? '0');
                    $('#total_ahli_pemilik_produk').text(res.total_ahli_pemilik_produk ?? '0');
                    $('#total_ahli_geran').text(res.total_ahli_geran ?? '0');
                }
            });
        });
    </script>
</body>

</html>
