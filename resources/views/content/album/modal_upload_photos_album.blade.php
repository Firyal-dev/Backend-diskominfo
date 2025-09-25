<section id="basic-modals">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal fade text-left" id="photos-album" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Masukkan foto ke album</h5>
                                </div>
                                <form action="{{ route('content.uploadAlbumPhotos') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="album_id" :value="albumId">
                                    <div class="row gallery">
                                        @forelse ($galeris as $index => $galeri)
                                        <div class="col-6 col-sm-6 col-lg-3 mt-2 mt-md-0 mb-md-0 mb-2 p-2">
                                            <label class="position-relative d-block">
                                                <input type="checkbox" name="selected_galeri[]" value="{{ $galeri->id }}"
                                                    class="form-check-input position-absolute top-0 end-0 m-2" style="z-index:2;">
                                                <img class="w-100" role="button" src="{{ asset('storage/' . $galeri->file_path) }}" alt="{{ $galeri->judul }}">
                                            </label>
                                        </div>
                                        @empty
                                        <div class="col-12">
                                            <h5 class="text-center">Upload foto terlebih dulu di Galeri</h5>
                                        </div>
                                        @endforelse
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">
                                            <span class="d-none d-sm-block">Simpan</span>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                            <span class="d-none d-sm-block">Batal</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>