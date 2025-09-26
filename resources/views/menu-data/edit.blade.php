@extends('layouts.dashboard')

@section('title', 'Edit Konten')

@section('content')
    <div class="page-heading">
        <h3>Edit Konten: {{ $menuData->judul }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Edit Konten</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('menu-data.update', $menuData) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="menu_id">Pilih Parent Menu</label>
                            <select class="form-control" id="menu_id" name="menu_id" required>
                                <option value="">-- Pilih Menu --</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}"
                                        {{ old('menu_id', $menuData->menu_id) == $menu->id ? 'selected' : '' }}>
                                        {{ $menu->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="judul">Judul Konten</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="{{ old('judul', $menuData->judul) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar/File Baru</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                            <small class="text-muted">Opsional. Kosongkan jika tidak ingin mengubah gambar. Ukuran maks
                                2MB.</small>
                            @if ($menuData->gambar_file_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $menuData->gambar_file_path) }}" alt="Current Image"
                                        width="150">
                                    <p class="text-muted">Gambar saat ini</p>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="dokumen">Dokumen Baru</label>
                            <input type="file" class="form-control" id="dokumen" name="dokumen">
                            <small class="text-muted">Opsional. Kosongkan jika tidak ingin mengubah dokumen.</small>
                            @if ($menuDataItem->file_path)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $menuDataItem->file_path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-info">
                                        Lihat Dokumen Saat Ini
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="isi_konten">Isi Konten</label>
                            <textarea class="form-control" id="isi_konten" name="isi_konten" rows="10" required>{{ old('isi_konten', $menuData->isi_konten) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('menu-data.index') }}" class="btn btn-light-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
