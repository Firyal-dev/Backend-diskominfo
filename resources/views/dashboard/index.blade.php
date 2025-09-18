@extends('layouts.dashboard')

@section('content')

    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Dashboad Diskomifo</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                {{-- AWAL DARI PERUBAHAN KARTU STATISTIK --}}
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
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
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi bi-file-earmark-richtext-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Konten</h6>
                                        {{-- Ganti angka statis ini dengan variabel dari controller, contoh: {{ $jumlahKonten }} --}}
                                        <h6 class="font-extrabold mb-0">50</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi bi-menu-button-wide-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Menu</h6>
                                        {{-- Ganti angka statis ini dengan variabel dari controller, contoh: {{ $jumlahMenu }} --}}
                                        <h6 class="font-extrabold mb-0">8</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi bi-person-fill-gear"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Admin</h6>
                                        {{-- Ganti angka statis ini dengan variabel dari controller, contoh: {{ $jumlahAdmin }} --}}
                                        <h6 class="font-extrabold mb-0">3</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- AKHIR DARI PERUBAHAN KARTU STATISTIK --}}

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- Judul grafik bisa disesuaikan --}}
                                <h4>Grafik Penambahan Konten Bulanan</h4>
                            </div>
                            <div class="card-body">
                                {{-- Elemen grafik ini perlu diinisialisasi dengan data yang relevan dari controller --}}
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
                                    {{-- Tabel ini sebaiknya diisi dengan data dari tb_agenda yang akan datang --}}
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
        <td>{{ $agenda->deskripsi }}</td>
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
