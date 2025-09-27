@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>{{ $album->nama }}</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('album.index') }}">Album</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $album->nama }}</li>
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
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('album.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                            <h5 class="card-title">Foto Album</h5>
                        </div>
                        <div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('album.photos.create', $album->id) }}" class="btn btn-primary">Tambah Foto</a>
                                <form id="deletePhotosAlbumForm" action="{{ route('album.photos.destroy', $album->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" id="deletePhotosAlbumBtn">
                                        <i class="bi bi-trash-fill"></i> Hapus Foto
                                        <span id="selectedCountPhotosAlbum" class="badge bg-light text-dark ms-1" style="display:none;">0</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gallery" id="albumPhotosCheckboxes">
                            @forelse ($galeris as $galeri)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2 p-2">
                                <label class="position-relative d-block">
                                    <input type="checkbox" name="selected_photosAlbum[]" value="{{ $galeri->id }}"
                                        class="form-check-input position-absolute top-0 end-0 m-2" style="z-index:2;">
                                    <img class="w-100" role="button" src="{{ $galeri->file_url }}" alt="{{ $galeri->judul }}">
                                </label>
                            </div>
                            @empty
                            <div class="col-12">
                                <h5 class="text-center">Belum ada foto di album ini.</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Delete berjamaah -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deletePhotosAlbumForm');
        const albumPhotos = document.getElementById('albumPhotosCheckboxes');

        deleteForm.addEventListener('submit', function(e) {
            // Hapus input hidden sebelumnya
            deleteForm.querySelectorAll('input[name="selected_photosAlbum[]"]').forEach(el => el.remove());

            // Ambil semua checkbox yang dicentang
            albumPhotos.querySelectorAll('input[type="checkbox"][name="selected_photosAlbum[]"]:checked').forEach(function(checkbox) {
                // Buat input hidden di form toolbar
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_photosAlbum[]';
                hidden.value = checkbox.value;
                deleteForm.appendChild(hidden);
            });
        });
    });
</script>

<!-- Menghitung jumlah foto yang dipilih -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const albumPhotos = document.getElementById('albumPhotosCheckboxes');
        const selectedCount = document.getElementById('selectedCountPhotosAlbum');
        const deleteBtn = document.getElementById('deletePhotosAlbumBtn');

        function updateSelectedCount() {
            const checked = albumPhotos.querySelectorAll('input[type="checkbox"][name="selected_photosAlbum[]"]:checked').length;
            if (checked > 0) {
                selectedCount.style.display = 'inline-block';
                selectedCount.textContent = checked;
                deleteBtn.disabled = false;
            } else {
                selectedCount.style.display = 'none';
                deleteBtn.disabled = true;
            }
        }

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