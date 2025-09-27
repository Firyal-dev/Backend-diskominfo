{{-- ADD PHOTOS TO ALBUM VIEW - album-photos-create.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('album.index') }}">Album</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('album.photos.index', $album->id) }}">{{ $album->nama }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Foto</li>
                </ol>
            </nav>
            <h3 class="h3 d-none d-sm-block">Masukkan Foto ke Album</h3>
            <h5 class="d-sm-none">Masukkan Foto ke Album</h5>
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
                            <a href="{{ route('album.photos.index', $album->id) }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i>
                                <span class="d-none d-sm-inline ms-1">Kembali</span>
                            </a>
                            <h4 class="card-title mb-0">Pilih foto untuk album "{{ $album->nama }}"</h4>
                        </div>

                        {{-- Selection Summary --}}
                        <div class="alert alert-info mb-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">Centang foto yang ingin ditambahkan ke album
                                </div>
                                <div class="badge bg-primary fs-6" id="selectedCountDisplay">
                                    <span id="selectedPhotoCount">0</span> dipilih
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('album.photos.store', $album->id) }}" method="POST" id="addPhotosForm">
                            @csrf

                            <div class="row g-3" id="gallerySelection">
                                @forelse ($galeris as $galeri)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card border h-100 photo-selection-card" data-photo-id="{{ $galeri->id }}">
                                        <div class="position-relative">
                                            {{-- Checkbox --}}
                                            <div class="form-check position-absolute top-0 end-0 m-2" style="z-index: 3;">
                                                <input type="checkbox" name="selected_galeri[]" value="{{ $galeri->id }}"
                                                    class="form-check-input photo-checkbox"
                                                    style="transform: scale(1.3); box-shadow: 0 0 0 2px rgba(255,255,255,0.9);">
                                            </div>

                                            {{-- Image --}}
                                            <div class="ratio ratio-1x1">
                                                <img class="w-100 h-100 object-fit-cover card-img-top photo-img"
                                                    src="{{ asset('storage/' . $galeri->file_path) }}"
                                                    alt="{{ $galeri->judul }}"
                                                    loading="lazy">
                                            </div>
                                        </div>

                                        <div class="card-body p-2">
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
                                        <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">Tidak ada foto tersedia</h5>
                                        <p class="text-muted">Upload foto terlebih dahulu di menu Galeri</p>
                                        <a href="{{ route('galeri.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>Upload Foto
                                        </a>
                                    </div>
                                </div>
                                @endforelse
                            </div>

                            {{-- Action Buttons --}}
                            @if(count($galeris) > 0)
                            <div class="card-footer bg-light">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="selectAllBtn">
                                            <i class="bi bi-check-square me-1"></i>Pilih Semua
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="clearAllBtn">
                                            <i class="bi bi-square me-1"></i>Hapus Pilihan
                                        </button>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('album.photos.index', $album->id) }}" class="btn btn-light-secondary">
                                            <i class="bi bi-x-circle me-1"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                                            <i class="bi bi-plus-circle me-1"></i>
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            <span class="d-none d-sm-inline">Tambahkan ke Album</span>
                                            <span class="d-sm-none">Tambahkan</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('addPhotosForm');
        const checkboxes = document.querySelectorAll('.photo-checkbox');
        const selectedCountDisplay = document.getElementById('selectedPhotoCount');
        const submitBtn = document.getElementById('submitBtn');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const clearAllBtn = document.getElementById('clearAllBtn');

        // Update selection count and UI
        function updateSelection() {
            const selectedCount = document.querySelectorAll('.photo-checkbox:checked').length;
            const totalCount = checkboxes.length;

            // Update counter
            selectedCountDisplay.textContent = selectedCount;

            // Update submit button
            if (selectedCount > 0) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-success');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-secondary');
            }

            // Update select all button
            if (selectedCount === totalCount && totalCount > 0) {
                selectAllBtn.innerHTML = '<i class="bi bi-check-square-fill me-1"></i>Semua Terpilih';
                selectAllBtn.disabled = true;
            } else {
                selectAllBtn.innerHTML = '<i class="bi bi-check-square me-1"></i>Pilih Semua';
                selectAllBtn.disabled = false;
            }

            // Update clear button
            clearAllBtn.disabled = selectedCount === 0;

            // Update card appearance
            checkboxes.forEach(checkbox => {
                const card = checkbox.closest('.photo-selection-card');
                const overlay = card.querySelector('.selection-overlay');
                const img = card.querySelector('.photo-img');

                if (checkbox.checked) {
                    card.classList.add('border-primary');
                    overlay.style.display = 'flex';
                    img.style.opacity = '0.8';
                } else {
                    card.classList.remove('border-primary');
                    overlay.style.display = 'none';
                    img.style.opacity = '1';
                }
            });
        }

        // Handle individual checkbox changes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelection);
        });

        // Handle select all
        selectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) {
                    checkbox.checked = true;
                }
            });
            updateSelection();
        });

        // Handle clear all
        clearAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelection();
        });

        // Handle card click (toggle checkbox)
        document.querySelectorAll('.photo-selection-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking directly on checkbox
                if (e.target.type !== 'checkbox') {
                    const checkbox = card.querySelector('.photo-checkbox');
                    checkbox.checked = !checkbox.checked;
                    updateSelection();
                }
            });
        });

        // Handle form submission
        form.addEventListener('submit', function(e) {
            const selectedCount = document.querySelectorAll('.photo-checkbox:checked').length;

            if (selectedCount === 0) {
                e.preventDefault();
                alert('Pilih minimal satu foto untuk ditambahkan ke album');
                return;
            }

            // Show loading state
            const spinner = submitBtn.querySelector('.spinner-border');
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');

            // Update button text
            const btnText = submitBtn.querySelector('.d-none.d-sm-inline') || submitBtn.querySelector('.d-sm-none');
            btnText.textContent = 'Menyimpan...';
        });

        // Initial update
        updateSelection();
    });
</script>

<style>
    /* Custom styles for photo selection */
    .photo-selection-card {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .photo-selection-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .selection-overlay {
        border-radius: calc(0.375rem - 1px);
    }

    .photo-img {
        transition: opacity 0.2s ease;
    }

    /* Mobile specific styles */
    @media (max-width: 575.98px) {
        .card-body {
            padding: 1rem;
        }

        .card-footer {
            padding: 1rem;
        }

        .photo-checkbox {
            transform: scale(1.5) !important;
        }

        .alert {
            padding: 0.75rem;
            font-size: 0.875rem;
        }
    }

    /* Loading state styles */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

@endsection