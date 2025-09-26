@extends('layouts.dashboard')

@section('title', 'Manajemen Konten')
@section('content')
    <div class="page-heading">
        <h3>Manajemen Konten Menu</h3>
        <p class="text-subtitle text-muted">Daftar semua konten dinamis seperti berita, pengumuman, dll.</p>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('menu-data.create') }}" class="btn btn-primary">Tambah Konten Baru</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Judul Konten</th>
                                    <th>Parent Menu</th>
                                    <th>Dokumen</th>

                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menuDataItems as $item)
                                    <tr>
                                        <td>
                                            @if ($item->gambar_file_path)
                                                <img src="{{ asset('storage/' . $item->gambar_file_path) }}"
                                                    alt="{{ $item->judul }}" width="100">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->menu->nama ?? 'N/A' }}</td>
                                        <td>
                                            @if ($item->file_path)
                                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Unduh
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('menu-data.edit', $item) }}"
                                                class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('menu-data.destroy', $item) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada konten.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $menuDataItems->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection
</div>
