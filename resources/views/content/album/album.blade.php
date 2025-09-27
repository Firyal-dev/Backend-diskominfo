{{-- INDEX VIEW - album-index.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manajemen Album</li>
                </ol>
            </nav>
            <h3 class="h3 d-none d-sm-block">Manajemen Konten</h3>
            <h5 class="d-sm-none">Manajemen Konten</h5>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-3">Album</h5>

                        {{-- Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <a href="{{ route('album.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                <span class="d-none d-sm-inline">Buat Album</span>
                                <span class="d-sm-none">Buat</span>
                            </a>
                            <form id="deleteAlbumForm" action="{{ route('album.destroy') }}" method="POST" class="flex-fill flex-sm-grow-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100 w-sm-auto" id="deleteAlbumBtn" disabled>
                                    <i class="bi bi-trash-fill me-1"></i>
                                    <span class="d-none d-sm-inline">Hapus Album</span>
                                    <span class="d-sm-none">Hapus</span>
                                    <span id="selectedCountAlbum" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Selection Info (Mobile) --}}
                        <div class="alert alert-info d-sm-none mb-3" id="mobileSelectionInfo" style="display: none !important;">
                            <small>
                                <i class="bi bi-info-circle me-1"></i>
                                Ketuk kotak centang untuk memilih album yang akan dihapus
                            </small>
                        </div>

                        <div class="row g-3" id="albumCheckboxes">
                            @forelse ($albums as $album)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="position-relative">
                                        {{-- Checkbox --}}
                                        <div class="form-check position-absolute top-0 start-0 m-2" style="z-index: 3;">
                                            <input type="checkbox" name="selected_album[]" value="{{ $album->id }}"
                                                class="form-check-input"
                                                style="transform: scale(1.2); box-shadow: 0 0 0 2px rgba(255,255,255,0.8);">
                                        </div>

                                        {{-- Photo Count Badge --}}
                                        <span class="badge bg-primary position-absolute top-0 end-0 m-2" style="z-index: 2;">
                                            {{ $album->galeri_count }}
                                            <span class="d-none d-sm-inline">Foto</span>
                                        </span>

                                        {{-- Album Cover --}}
                                        <div class="ratio ratio-4x3">
                                            <img class="w-100 h-100 object-fit-cover card-img-top"
                                                src="{{ $album->cover_album_url ? asset('storage/' . $album->cover_album_url) : asset('img/placeholder.webp') }}"
                                                alt="{{ $album->nama }}"
                                                loading="lazy">
                                        </div>
                                    </div>

                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-3 text-truncate" title="{{ $album->nama }}">
                                            {{ $album->nama }}
                                        </h6>

                                        {{-- Action Buttons --}}
                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                            <a href="{{ route('album.photos.index', $album->id) }}"
                                                class="btn btn-outline-primary btn-sm flex-fill">
                                                <i class="bi bi-eye me-1"></i>
                                                <span class="d-none d-lg-inline">Lihat Album</span>
                                                <span class="d-lg-none">Lihat</span>
                                            </a>
                                            <a href="{{ route('album.edit', $album->id) }}"
                                                class="btn btn-outline-warning btn-sm flex-fill">
                                                <i class="bi bi-pencil me-1"></i>
                                                <span class="d-none d-lg-inline">Edit Album</span>
                                                <span class="d-lg-none">Edit</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-collection fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">Tidak ada album ditemukan</h5>
                                    <p class="text-muted">Mulai dengan membuat album pertama</p>
                                    <a href="{{ route('album.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Buat Album
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

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteAlbumForm');
        const album = document.getElementById('albumCheckboxes');
        const selectedCount = document.getElementById('selectedCountAlbum');
        const deleteBtn = document.getElementById('deleteAlbumBtn');
        const mobileInfo = document.getElementById('mobileSelectionInfo');

        // Handle form submission
        deleteForm.addEventListener('submit', function(e) {
            const checkedBoxes = album.querySelectorAll('input[type="checkbox"][name="selected_album[]"]:checked');

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu album untuk dihapus');
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} album yang dipilih?`)) {
                e.preventDefault();
                return;
            }

            // Clear existing hidden inputs
            deleteForm.querySelectorAll('input[name="selected_album[]"]').forEach(el => el.remove());

            // Add hidden inputs for checked items
            checkedBoxes.forEach(function(checkbox) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_album[]';
                hidden.value = checkbox.value;
                deleteForm.appendChild(hidden);
            });
        });

        // Update selection count and button state
        function updateSelectedCount() {
            const checked = album.querySelectorAll('input[type="checkbox"][name="selected_album[]"]:checked').length;

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
        if (album) {
            album.addEventListener('change', function(e) {
                if (e.target.matches('input[type="checkbox"][name="selected_album[]"]')) {
                    updateSelectedCount();
                }
            });
            updateSelectedCount();
        }
    });
</script>

@endsection