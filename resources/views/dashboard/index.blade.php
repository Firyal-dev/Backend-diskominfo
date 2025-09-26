@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="page-heading">
    <h3>Dashboard Diskominfo</h3>
    <p class="text-subtitle text-muted">Ringkasan data dan aktivitas terbaru</p>
</div>

<div class="page-content">
    <section class="row">
        {{-- ### START: STATISTIC CARDS ### --}}
        <div class="row">
            {{-- Card Jumlah Agenda --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon purple me-3">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Jumlah Agenda</h6>
                            <h5 class="mb-0 fw-bold">{{ $jumlahAgenda }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Jumlah Foto --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-warning me-3">
                            <i class="bi bi-images"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Jumlah Foto</h6>
                            <h5 class="mb-0 fw-bold">{{ $jumlahFoto }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Jumlah Konten --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon blue me-3">
                            <i class="bi bi-file-earmark-richtext-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Jumlah Konten</h6>
                            <h5 class="mb-0 fw-bold">{{ $jumlahKonten }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Jumlah Menu --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon green me-3">
                            <i class="bi bi-menu-button-wide-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Jumlah Menu</h6>
                            <h5 class="mb-0 fw-bold">{{ $jumlahMenu }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Jumlah Admin --}}
            <div class="col-6 col-lg-3 col-md-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon red me-3">
                            <i class="bi bi-person-fill-gear"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Jumlah Admin</h6>
                            <h5 class="mb-0 fw-bold">{{ $jumlahAdmin }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ### END: STATISTIC CARDS ### --}}

        <div class="row">
            {{-- Grafik Konten --}}
            <div class="col-12 col-xl-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-header">
                        <h5 class="mb-0">Grafik Penambahan Konten Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart-profile-visit" style="height: 320px;"></div>
                    </div>
                </div>
            </div>

            {{-- Agenda Terdekat --}}
            <div class="col-12 col-xl-6">
                <div class="border-0 shadow-sm card">
                    <div class="card-header">
                        <h5 class="mb-0">Agenda Terdekat</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Agenda</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($agendasTerdekat as $agenda)
                                    <tr>
                                        <td>{{ $agenda->agenda }}</td>
                                        <td>{{ $agenda->tanggal->format('d F Y') }}</td>
                                        <td>{{ Str::limit($agenda->deskripsi, 50) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada agenda terdekat.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'line',
                height: 320,
                toolbar: { show: false },
            },
            series: [{
                name: 'Konten Baru',
                data: @json($chartData['jumlah']) // dari controller
            }],
            xaxis: {
                categories: @json($chartData['bulan']), // contoh: ["Jan", "Feb", "Mar", ...]
                labels: {
                    style: { fontSize: '13px' }
                }
            },
            colors: ['#435ebe'], // warna khas Mazer
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 5,
                colors: ['#435ebe'],
                strokeColors: '#fff',
                strokeWidth: 2,
            },
            dataLabels: { enabled: false },
            grid: {
                strokeDashArray: 4,
                borderColor: '#e0e6ed'
            },
            yaxis: {
                labels: { style: { fontSize: '13px' } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-profile-visit"), options);
        chart.render();
    });
</script>
@endpush
