{{-- resources/views/menu/create.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <h3>Tambah Menu Baru</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Formulir Menu</h4></div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form action="{{ route('menu.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama">Nama Menu</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                            </div>
                             <div class="form-group">
                                <label for="urutan">Urutan</label>
                                <input type="number" class="form-control" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="statis" {{ old('kategori') == 'statis' ? 'selected' : '' }}>Statis</option>
                                    <option value="dinamis" {{ old('kategori') == 'dinamis' ? 'selected' : '' }}>Dinamis</option>
                                    <option value="dinamis-tabel" {{ old('kategori') == 'dinamis-tabel' ? 'selected' : '' }}>Dinamis (Tabel)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Menu Induk (Parent)</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach ($parentMenus as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="mb-1 btn btn-primary me-1">Simpan</button>
                            <a href="{{ route('menu.index') }}" class="mb-1 btn btn-light-secondary me-1">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsectione
