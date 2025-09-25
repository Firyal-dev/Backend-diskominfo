<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Foto Album</h5>
                    </div>
                    <div class="card-body">
                        <div class="row gallery" id="albumPhotosCheckboxes">
                            @php
                            $filteredGaleri = $galeris->where('album_id', '!=', null);
                            @endphp
                            @forelse ($filteredGaleri as $index => $galeri)
                            <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2"
                                x-show="albumId === {{ $galeri->album_id }}">
                                <div class="position-relative">
                                    <input type="checkbox" name="selected_photosAlbum[]" value="{{ $galeri->id }}"
                                        class="form-check-input position-absolute top-0 end-0 m-2" style="z-index:2;">
                                        <img class="w-100" src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}">
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