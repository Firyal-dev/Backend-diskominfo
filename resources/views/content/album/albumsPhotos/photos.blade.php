{{-- ALBUM PHOTOS INDEX VIEW - album-photos-index.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('album.index') }}">Album</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $album->nama }}</li>
                </ol>
            </nav>
            <h3 class="h3 d-none d-sm-block">{{ $album->nama }}</h3>
            <h5 class="d-sm-none">{{ $album->nama }}</h5>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- Back Button and Title --}}
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <a href="{{ route('album.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i>
                                <span class="d-none d-sm-inline ms-1">Kembali</span>
                            </a>
                            <h5 class="card-title mb-0">Foto Album</h5>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <a href="{{ route('album.photos.create', $album->id) }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                <span class="d-none d-sm-inline">Tambah Foto</span>
                                <span class="d-sm-none">Tambah</span>
                            </a>
                            <form id="deletePhotosAlbumForm" action="{{ route('album.photos.destroy', $album->id) }}" method="POST" class="flex-fill flex-sm-grow-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100 w-sm-auto" id="deletePhotosAlbumBtn" disabled>
                                    <i class="bi bi-trash-fill me-1"></i>
                                    <span class="d-none d-sm-inline">Hapus Foto</span>
                                    <span class="d-sm-none">Hapus</span>
                                    <span id="selectedCountPhotosAlbum" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Selection Info (Mobile) --}}
                        <div class="alert alert-info d-sm-none mb-3" id="mobileSelectionInfo" style="display: none !important;">
                            <small>
                                <i class="bi bi-info-circle me-1"></i>
                                Ketuk kotak centang untuk memilih foto yang akan dihapus
                            </small>
                        </div>

                        <div class="row g-3" id="albumPhotosCheckboxes">
                            @forelse ($galeris as $index => $galeri)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="position-relative">
                                        {{-- Checkbox --}}
                                        <div class="form-check position-absolute top-0 end-0 m-2" style="z-index: 3;">
                                            <input type="checkbox" name="selected_photosAlbum[]" value="{{ $galeri->id }}"
                                                class="form-check-input"
                                                style="transform: scale(1.2); box-shadow: 0 0 0 2px rgba(255,255,255,0.8);">
                                        </div>

                                        {{-- Image --}}
                                        <div class="ratio ratio-1x1">
                                            <a href="#" data-bs-target="#albumPhotosCarousel" data-bs-slide-to="{{ $index }}">
                                                <img class="w-100 h-100 object-fit-cover rounded-top"
                                                    data-bs-toggle="modal" data-bs-target="#albumPhotosModal"
                                                    src="{{ $galeri->file_url }}"
                                                    alt="{{ $galeri->judul }}"
                                                    loading="lazy">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-body p-2 p-md-3">
                                        <h6 class="card-title mb-1 text-truncate small" title="{{ $galeri->judul }}">
                                            {{ $galeri->judul }}
                                        </h6>
                                        <p class="card-text text-muted small mb-0">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($galeri->tgl_upload)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-image fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">Belum ada foto di album ini</h5>
                                    <p class="text-muted">Mulai dengan menambahkan foto dari galeri</p>
                                    <a href="{{ route('album.photos.create', $album->id) }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Foto
                                    </a>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modal for Photo Gallery --}}
@if(count($galeris) > 0)
<div class="modal fade" id="albumPhotosModal" tabindex="-1" role="dialog"
    aria-labelledby="albumPhotosModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="albumPhotosModalTitle">{{ $album->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="albumPhotosCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    {{-- Carousel Indicators --}}
                    <div class="carousel-indicators">
                        @foreach ($galeris as $index => $galeri)
                        <button type="button" data-bs-target="#albumPhotosCarousel" data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    {{-- Carousel Items --}}
                    <div class="carousel-inner">
                        @foreach ($galeris as $index => $galeri)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="ratio ratio-16x9">
                                <img class="d-block w-100 h-100 object-fit-contain"
                                    src="{{ $galeri->file_url }}"
                                    alt="{{ $galeri->judul }}">
                            </div>
                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-2">
                                <h5>{{ $galeri->judul }}</h5>
                                <p>{{ \Carbon\Carbon::parse($galeri->tgl_upload)->format('d F Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Controls --}}
                    @if(count($galeris) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#albumPhotosCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#albumPhotosCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deletePhotosAlbumForm');
        const albumPhotos = document.getElementById('albumPhotosCheckboxes');
        const selectedCount = document.getElementById('selectedCountPhotosAlbum');
        const deleteBtn = document.getElementById('deletePhotosAlbumBtn');
        const mobileInfo = document.getElementById('mobileSelectionInfo');

        // Handle form submission
        deleteForm.addEventListener('submit', function(e) {
            const checkedBoxes = albumPhotos.querySelectorAll('input[type="checkbox"][name="selected_photosAlbum[]"]:checked');

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu foto untuk dihapus');
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} foto yang dipilih dari album ini?`)) {
                e.preventDefault();
                return;
            }

            // Clear existing hidden inputs
            deleteForm.querySelectorAll('input[name="selected_photosAlbum[]"]').forEach(el => el.remove());

            // Add hidden inputs for checked items
            checkedBoxes.forEach(function(checkbox) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_photosAlbum[]';
                hidden.value = checkbox.value;
                deleteForm.appendChild(hidden);
            });
        });

        // Update selection count and button state
        function updateSelectedCount() {
            const checked = albumPhotos.querySelectorAll('input[type="checkbox"][name="selected_photosAlbum[]"]:checked').length;

            if (checked > 0) {
                selectedCount.style.display = 'inline-block';
                selectedCount.textContent = checked;
                deleteBtn.disabled = false;
                deleteBtn.classList.remove('btn-danger');
                deleteBtn.classList.add('btn-warning');

                // Show mobile info on first selection
                if (window.innerWidth < 576 && mobileInfo) {
                    mobileInfo.style.display = 'block';
                }
            } else {
                selectedCount.style.display = 'none';
                deleteBtn.disabled = true;
                deleteBtn.classList.remove('btn-warning');
                deleteBtn.classList.add('btn-danger');

                // Hide mobile info
                if (mobileInfo) {
                    mobileInfo.style.display = 'none';
                }
            }
        }

        // Listen for checkbox changes
        if (albumPhotos) {
            albumPhotos.addEventListener('change', function(e) {
                if (e.target.matches('input[type="checkbox"][name="selected_photosAlbum[]"]')) {
                    updateSelectedCount();
                }
            });
            updateSelectedCount();
        }
    });
</script>

@endsection