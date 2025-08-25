@extends('home')
@section('title-dashboard', 'Admin')
@section('title', 'Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active">Statistik</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Total ahli</h5>
                    <span>Ahli : <strong>{{ $total_ahli }}</strong></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Pending Approval</h5>
                    <span>Semua : <strong>{{ $total_pending_approval }}</strong></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Pending Approval</h5>
                    <span>HQ : <strong>{{ $total_pending_approval_hq }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-border card-outline card-danger" style="border-radius: 12px">
        <div class="card-header">
            <h3 class="card-title">Total Keahlian</h3>
            {{-- <div class="float-right">
                <select id="yearFilter" class="form-control" style="width: 120px;">
                    <option value="">Pilih Tahun</option>
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}
                        </option>
                    @endfor
                </select>
            </div> --}}
        </div>
        <div class="card-body">
            <div id="chartLoading" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
            <canvas id="chart-keahlian" style="height: 400px;"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Total Collected Fee : </h5>
                    <span><strong>RM {{ number_format($total_collected_fee, 2) }}</strong></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Outstading Payment : </h5>
                    <span><strong>{{ $total_outstading }}</strong></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Outstading amount : </h5>
                    <span><strong>RM {{ number_format($total_outstading_fee, 2) }}</strong></span>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Renewal</h5>
                    <canvas id="pieRenewal"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Renewal Ketua Bahagian</h5>
                    <canvas id="pieBahagian"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-border" style="border-radius: 12px">
                <div class="card-body">
                    <h5>Renewal ketua cawangan</h5>
                    <canvas id="pieCawangan"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom-js')
<script>
    // =======================
    // Bar Chart: Total Keahlian
    // =======================
    document.addEventListener('DOMContentLoaded', function () {
        const chartCanvas = document.getElementById('chart-keahlian');
        const chartLoading = document.getElementById('chartLoading');

        // Show loading spinner
        chartLoading.style.display = 'block';
        chartCanvas.style.display = 'none';

        // Fetch data from the endpoint
        fetch('{{ route('chart.keahlian') }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading spinner and show chart
            chartLoading.style.display = 'none';
            chartCanvas.style.display = 'block';

            if (data.status === 'success') {
                const labels = Object.keys(data.data);
                const values = Object.values(data.data).map(val => parseInt(val));

                new Chart(chartCanvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Keahlian',
                            data: values,
                            backgroundColor: '#36A2EB',
                            borderColor: '#36A2EB',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Total Keahlian'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'City'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Total Keahlian by City',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Error fetching data:', data.message);
            }
        })
        .catch(error => {
            chartLoading.style.display = 'none';
            console.error('Fetch error:', error);
        });
    });

    // =======================
    // PIE CHART 1: % Renewal
    // =======================
    new Chart(document.getElementById('pieRenewal'), {
        type: 'pie',
        data: {
            labels: ['Sudah Renew', 'Belum Bayar Renewal'],
            datasets: [{
                data: [{{ $result_rewal['done_renewal'] }}, {{ $result_rewal['pending_renewal'] }}],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '% Renewal',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // =======================
    // PIE CHART 2: Penerimaan Ketua Bahagian
    // =======================
    new Chart(document.getElementById('pieBahagian'), {
        type: 'pie',
        data: {
            labels: ['Diterima', 'Pending'],
            datasets: [{
                data: [{{ $renewal_ketua_bahagian_data['0'] }}, {{ $renewal_ketua_bahagian_data['1'] }}],
                backgroundColor: ['#007bff', '#ffc107'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '% Penerimaan Renewal Ahli Ketua Bahagian',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // =======================
    // PIE CHART 3: Penerimaan Ketua Cawangan
    // =======================
    new Chart(document.getElementById('pieCawangan'), {
        type: 'pie',
        data: {
            labels: ['Diterima', 'Pending'],
            datasets: [{
                data: [70, 30], // Replace with actual data if available
                backgroundColor: ['#28a745', '#ffc107'],
                borderColor: ['#ffffff', '#ffffff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: '% Penerimaan Renewal Ahli Ketua Cawangan',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
