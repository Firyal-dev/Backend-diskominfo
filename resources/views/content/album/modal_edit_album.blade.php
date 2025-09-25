<section id="basic-modals">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal fade text-left" id="edit-album" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel1">Edit Album</h5>
                                </div>
                                <form method="post" action="{{ route('content.editAlbum', $album->id) }}" class="form form-vertical" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="first-judul-vertical">Edit Album</label>
                                                    <input type="text" id="first-judul-vertical" class="form-control"
                                                        name="nama" placeholder="Nama Album" value="{{ $album->nama }}">
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="foto-id-vertical">Cover Album (opsional)</label>
                                                        <input type="file" id="foto-id-vertical" class="form-control"
                                                            name="cover_album_url" placeholder="Cover Album">
                                                        @if($album->cover_album_url)
                                                        <img src="{{ asset('storage/' . $album->cover_album_url) }}" alt="Cover Album" class="img-fluid mt-2" style="max-height:100px;">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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