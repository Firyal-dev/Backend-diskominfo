@extends('layouts.dashboard')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>


<div class="page-heading" x-data="{ view: 'gallery' }">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Photo Gallery</h3>
                <p class="text-subtitle text-muted">Super simple photo gallery with albums.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Photo Gallery</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <a href="#" class="btn btn-primary">Tambah konten</a>
                        <div class="btn-group" role="group">
                            <button
                                class="btn"
                                :class="view === 'gallery' ? 'btn-primary' : 'btn-light'"
                                :disabled="view === 'gallery'"
                                @click="view = 'gallery'">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </button>
                            <button
                                class="btn"
                                :class="view === 'album' ? 'btn-primary' : 'btn-light'"
                                :disabled="view === 'album'"
                                @click="view = 'album'">
                                <i class="bi bi-grid-fill"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- GALERI --}}
                        <div x-show="view === 'gallery'">
                            <div class="row gallery" data-bs-toggle="modal" data-bs-target="#galleryModal">
                                @foreach(range(1,8) as $i)
                                <div class="col-6 col-sm-6 col-lg-3 mb-3">
                                    <a href="#">
                                        <img class="w-100 rounded shadow-sm"
                                            src="https://picsum.photos/500/300?random={{ $i }}"
                                            data-bs-target="#Gallerycarousel" data-bs-slide-to="{{ $i-1 }}">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ALBUM --}}
                        <div x-show="view === 'album'">
                            <div class="row">
                                @foreach(['Liburan','Keluarga','Sekolah','Kerja'] as $album)
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="card shadow-lg border border-primary">
                                        <img src="https://picsum.photos/800/400?random={{ $loop->index }}"
                                            class="card-img-top" alt="{{ $album }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $album }}</h5>
                                            <p class="card-text">Koleksi foto {{ $album }}.</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Lihat Album</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div> {{-- end card-body --}}
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog"
    aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Our Gallery Example</h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#Gallerycarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#Gallerycarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#Gallerycarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#Gallerycarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="https://picsum.photos/500/300?random=1">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://picsum.photos/500/300?random=2">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://picsum.photos/500/300?random=3">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://picsum.photos/500/300?random=4">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#Gallerycarousel" role="button" type="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#Gallerycarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection