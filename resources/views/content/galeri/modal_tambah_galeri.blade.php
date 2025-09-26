<section id="basic-modals">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal fade text-left" id="galeri" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Tambah foto</h5>
                                </div>
                                <form method="post" action="{{ route('content.uploadGaleri') }}" class="form form-vertical" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first-judul-vertical">Judul</label>
                                                        <input type="text" id="first-judul-vertical" class="form-control"
                                                            name="judul" placeholder="judul" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Foto</label>
                                                        <input type="file" id="foto-id-vertical" class="form-control"
                                                            name="file_path" placeholder="Foto" required>
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