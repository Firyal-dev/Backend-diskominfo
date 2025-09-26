<div class="page-heading">
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Album</h5>
                    </div>
                    <div class="card-body">
                        <div class="row gallery" id="albumCheckboxes">
                            @forelse ($albums as $album)
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="border rounded p-2 h-100 d-flex flex-column position-relative">
                                    <!-- Label jumlah foto -->
                                    <input type="checkbox" name="selected_album[]" value="{{ $album->id }}"
                                        class="form-check-input position-absolute top-0 start-0 m-3" style="z-index:2;">
                                    <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                        {{ $album->galeri_count }} Foto
                                    </span>

                                    <img class="w-100 rounded mb-2"
                                        src="{{ $album->cover_album_url ? asset('storage/' . $album->cover_album_url) : asset('img/placeholder.webp') }}"
                                        alt="Album">

                                    <h5 class="mb-1 text-truncate" title="{{ $album->nama }}">{{ $album->nama }}</h5>

                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                        <button @click="albumId = {{ $album->id }}; view = 'album-photos'" class="btn btn-outline-primary flex-fill">Lihat Album</button>
                                        <button data-bs-toggle="modal" data-bs-target="#edit-album" class="btn btn-outline-warning flex-fill">Edit Album</button>
                                    </div>
                                </div>
                            </div>

                            {{-- MODAL EDIT ALBUM --}}
                            @include('content.album.modal_edit_album')
                            @empty
                            <div class="col-12">
                                <div class="text-center">Tidak ada album ditemukan.</div>
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
        const deleteForm = document.getElementById('deleteAlbumForm');
        const album = document.getElementById('albumCheckboxes');

        deleteForm.addEventListener('submit', function(e) {
            // Hapus input hidden sebelumnya
            deleteForm.querySelectorAll('input[name="selected_album[]"]').forEach(el => el.remove());

            // Ambil semua checkbox yang dicentang
            album.querySelectorAll('input[type="checkbox"][name="selected_album[]"]:checked').forEach(function(checkbox) {
                // Buat input hidden di form toolbar
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_album[]';
                hidden.value = checkbox.value;
                deleteForm.appendChild(hidden);
            });
        });
    });
</script>

<!-- Menghitung jumlah album yang dipilih -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const album = document.getElementById('albumCheckboxes');
        const selectedCount = document.getElementById('selectedCountAlbum');
        const deleteBtn = document.getElementById('deleteAlbumBtn');

        function updateSelectedCount() {
            const checked = album.querySelectorAll('input[type="checkbox"][name="selected_album[]"]:checked').length;
            if (checked > 0) {
                selectedCount.style.display = 'inline-block';
                selectedCount.textContent = checked;
                deleteBtn.disabled = false;
            } else {
                selectedCount.style.display = 'none';
                deleteBtn.disabled = true;
            }
        }

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