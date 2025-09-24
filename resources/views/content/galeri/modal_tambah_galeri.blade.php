<section id="basic-modals">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <!--Basic Modal -->
                    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Tambah foto</h5>
                                </div>
                                <div class="modal-body">
                                    <form class="form form-vertical">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first-judul-vertical">Judul</label>
                                                        <input type="text" id="first-judul-vertical" class="form-control"
                                                            name="judul" placeholder="judul">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Foto</label>
                                                        <input type="file" id="foto-id-vertical" class="form-control"
                                                            name="foto" placeholder="Foto">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">
                                        <span class="d-none d-sm-block">Simpan</span>
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        <span class="d-none d-sm-block">Batal</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>