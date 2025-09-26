<section id="basic-modals">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal fade text-left" id="album" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Buat Album</h5>
                                </div>
                                <form method="post" action="{{ route('content.createAlbum') }}" class="form form-vertical" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="first-judul-vertical">Nama Album</label>
                                                    <input type="text" id="first-judul-vertical" class="form-control"
                                                        name="nama" placeholder="Nama Album" required>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Cover Album</label>
                                                        <input type="file" id="foto-id-vertical" class="form-control"
                                                            name="cover_album_url" placeholder="Cover Album">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle"></i>
                                            <span class="d-none d-sm-block">Simpan</span>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle"></i>
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