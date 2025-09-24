@extends('layouts.dashboard')

@section('content')
<div class="page-heading"><h3>Tambah Konten Baru</h3></div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Formulir Konten</h4></div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form action="{{ route('menu-data.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="menu_id">Pilih Parent Menu</label>
                        <select class="form-control" id="menu_id" name="menu_id" required>
                            <option value="">-- Pilih Menu --</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>{{ $menu->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Konten</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar/File</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <small class="text-muted">Opsional. Ukuran maks 2MB.</small>
                    </div>
                    <div class="form-group">
                        <label for="isi_konten">Isi Konten</label>
                        <textarea class="form-control" id="isi_konten" name="isi_konten" rows="10" required>{{ old('isi_konten') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('menu-data.index') }}" class="btn btn-light-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
