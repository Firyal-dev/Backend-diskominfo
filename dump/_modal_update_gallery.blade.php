<!-- Modal Update Gallery -->
<div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('content.update', ['content' => ':id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePhotoModalLabel">Update Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="">
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="file" name="file" accept="image/*" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var updateModal = document.getElementById('updatePhotoModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var judul = button.getAttribute('data-judul');
            var deskripsi = button.getAttribute('data-deskripsi');
            var foto = button.getAttribute('data-foto');

            var form = updateModal.querySelector('form');
            form.action = "{{ route('content.update', ':id') }}".replace(':id', id);

            // Isi value input
            updateModal.querySelector('input[name="judul"]').value = judul || '';
            updateModal.querySelector('input[name="deskripsi"]').value = deskripsi || '';

            // Preview foto lama
            var preview = updateModal.querySelector('#preview-foto-lama');
            if (foto) {
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'preview-foto-lama';
                    preview.style.maxWidth = '100px';
                    preview.classList.add('mt-2');
                    updateModal.querySelector('input[name="file"]').parentNode.appendChild(preview);
                }
                preview.src = foto;
                preview.style.display = 'block';
            } else if (preview) {
                preview.style.display = 'none';
            }
        });
    });
</script>