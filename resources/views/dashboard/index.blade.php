@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="page-heading">
        <h3>Dashboard Diskominfo</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                {{-- ### START: STATISTIC CARDS ### --}}
                <div class="row">
                    {{-- Card Jumlah Agenda --}}
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Agenda</h6>
                                        <h6 class="font-extrabold mb-0">{{ $jumlahAgenda }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card Jumlah Konten --}}
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi bi-file-earmark-richtext-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Konten</h6>
                                        {{-- [DIPERBAIKI] Menggunakan variabel dinamis --}}
                                        <h6 class="font-extrabold mb-0">{{ $jumlahKonten }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card Jumlah Menu --}}
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-menu-button-wide-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Menu</h6>
                                        {{-- [DIPERBAIKI] Menggunakan variabel dinamis --}}
                                        <h6 class="font-extrabold mb-0">{{ $jumlahMenu }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card Jumlah Admin --}}
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-person-fill-gear"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Admin</h6>
                                        {{-- [DIPERBAIKI] Menggunakan variabel dinamis --}}
                                        <h6 class="font-extrabold mb-0">{{ $jumlahAdmin }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ### END: STATISTIC CARDS ### --}}

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Penambahan Konten Bulanan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Agenda Terdekat</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
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
                                                    <td colspan="3" class="text-center">Tidak ada agenda terdekat.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
