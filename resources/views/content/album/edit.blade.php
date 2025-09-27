{{-- EDIT VIEW - album-edit.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('album.index') }}">Album</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h3 class="h3 d-none d-sm-block">Edit Album</h3>
            <h5 class="d-sm-none">Edit Album</h5>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('album.update', $album->id) }}" method="POST" enctype="multipart/form-data" id="albumEditForm">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Album <span class="text-danger">*</span></label>
                                <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" value="{{ old('nama', $album->nama) }}" placeholder="Masukkan nama album" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="cover_album_url" class="form-label">Cover Album</label>
                                <input type="file" id="cover_album_url" class="form-control @error('cover_album_url') is-invalid @enderror"
                                    name="cover_album_url" accept="image/*">
                                <div class="form-text">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Opsional. Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah cover.
                                    </small>
                                </div>
                                @error('cover_album_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Current Cover Preview --}}
                                @if($album->cover_album_url)
                                <div class="mt-3">
                                    <label class="form-label">Cover Saat Ini:</label>
                                    <div class="border rounded p-2">
                                        <img src="{{ asset('storage/' . $album->cover_album_url) }}"
                                            alt="Cover Album" class="img-fluid rounded"
                                            style="max-height: 150px; max-width: 100%;" id="currentCover">
                                    </div>
                                </div>
                                @endif

                                {{-- New Image Preview --}}
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <label class="form-label">Preview Cover Baru:</label>
                                    <div class="border rounded p-2">
                                        <img id="previewImg" class="img-fluid rounded" style="max-height: 200px; max-width: 100%;">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                <a href="{{ route('album.index') }}" class="btn btn-light-secondary order-2 order-sm-1">
                                    <i class="bi bi-arrow-left me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary order-1 order-sm-2" id="submitBtn">
                                    <i class="bi bi-check-circle me-1"></i>
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                    Simpan Perubahan
                                </button>
                            </div>
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
        const fileInput = document.getElementById('cover_album_url');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const currentCover = document.getElementById('currentCover');
        const form = document.getElementById('albumEditForm');
        const submitBtn = document.getElementById('submitBtn');

        // Image preview functionality
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar!');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file tidak boleh lebih dari 2MB!');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';

                    // Dim current cover to show it will be replaced
                    if (currentCover) {
                        currentCover.style.opacity = '0.5';
                        currentCover.parentElement.insertAdjacentHTML('beforeend',
                            '<div class="position-absolute top-50 start-50 translate-middle"><span class="badge bg-warning">Akan diganti</span></div>');
                        currentCover.parentElement.style.position = 'relative';
                    }
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                // Restore current cover opacity
                if (currentCover) {
                    currentCover.style.opacity = '1';
                    const replaceLabel = currentCover.parentElement.querySelector('.position-absolute');
                    if (replaceLabel) replaceLabel.remove();
                }
            }
        });

        // Form submission handling
        form.addEventListener('submit', function(e) {
            const spinner = submitBtn.querySelector('.spinner-border');
            const btnText = submitBtn.querySelector('i').nextSibling;

            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.textContent = ' Menyimpan...';
        });
    });
</script>

<style>
    /* Custom styles for better mobile experience */
    @media (max-width: 575.98px) {
        .card-body {
            padding: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        #imagePreview img,
        #currentCover {
            max-height: 150px;
        }
    }

    /* Loading state styles */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Image preview styles */
    #imagePreview,
    .mt-3 {
        transition: all 0.3s ease;
    }

    img.img-fluid {
        object-fit: cover;
        border-radius: 0.375rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>

@endsection