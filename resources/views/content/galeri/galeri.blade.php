@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Manajemen Konten</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manajemen Konten</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Galeri</h5>
                        <div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('galeri.create') }}" class="btn btn-primary">Tambah Foto</a>
                                <form id="deleteGaleriForm" action="{{ route('galeri.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" id="deleteGaleriBtn" disabled>
                                        <i class="bi bi-trash-fill"></i> Hapus Foto
                                        <span id="selectedCountGaleri" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gallery" id="galleryCheckboxes">
                            @forelse ($galeris as $index => $galeri)
                            <div class="col-12 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2">
                                <div class="position-relative">
                                    <!-- Checkbox pojok kanan atas -->
                                    <input type="checkbox" name="selected_galeri[]" value="{{ $galeri->id }}"
                                        class="form-check-input position-absolute top-0 end-0 m-2" style="z-index:2;">

                                    <!-- Gambar -->
                                    <a href="#" data-bs-target="#Gallerycarousel" data-bs-slide-to="{{ $index }}">
                                        <img class="w-100" data-bs-toggle="modal" data-bs-target="#galleryModal" src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}">
                                    </a>
                                    <div>
                                        <h6 class="mt-2 text-truncate" title="{{ $galeri->judul }}">{{ $galeri->judul }}</h6>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p>{{ $galeri->tgl_upload }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <h5 class="text-center">Tidak ada foto</h5>
                            </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog"
    aria-labelledby="galleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalTitle">Galeri</h5>
            </div>
            <div class="modal-body">

                <div id="Gallerycarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

                    {{-- Carousel items --}}
                    <div class="carousel-inner">
                        @foreach ($galeris as $index => $galeri)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}">
                        </div>
                        @endforeach
                    </div>

                    {{-- Controls --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#Gallerycarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#Gallerycarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete berjamaah -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteGaleriForm');
        const gallery = document.getElementById('galleryCheckboxes');

        deleteForm.addEventListener('submit', function(e) {
            // Hapus input hidden sebelumnya
            deleteForm.querySelectorAll('input[name="selected_galeri[]"]').forEach(el => el.remove());

            // Ambil semua checkbox yang dicentang
            gallery.querySelectorAll('input[type="checkbox"][name="selected_galeri[]"]:checked').forEach(function(checkbox) {
                // Buat input hidden di form toolbar
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_galeri[]';
                hidden.value = checkbox.value;
                deleteForm.appendChild(hidden);
            });
        });
    });
</script>

<!-- Menghitung jumlah foto yang dipilih -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gallery = document.getElementById('galleryCheckboxes');
        const selectedCount = document.getElementById('selectedCountGaleri');
        const deleteBtn = document.getElementById('deleteGaleriBtn');

        function updateSelectedCount() {
            const checked = gallery.querySelectorAll('input[type="checkbox"][name="selected_galeri[]"]:checked').length;
            if (checked > 0) {
                selectedCount.style.display = 'inline-block';
                selectedCount.textContent = checked;
                deleteBtn.disabled = false;
            } else {
                selectedCount.style.display = 'none';
                deleteBtn.disabled = true;
            }
        }

        if (gallery) {
            gallery.addEventListener('change', function(e) {
                if (e.target.matches('input[type="checkbox"][name="selected_galeri[]"]')) {
                    updateSelectedCount();
                }
            });
            updateSelectedCount();
        }
    });
</script>

@endsection