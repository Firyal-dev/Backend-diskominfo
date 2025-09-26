{{-- resources/views/menu/index.blade.php --}}
@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <h3>Manajemen Menu</h3>
    <p class="text-subtitle text-muted">Kelola struktur menu navigasi website.</p>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('menu.create') }}" class="btn btn-primary">Tambah Menu Baru</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                   <table class="table table-striped" id="table1">
    <thead>
        <tr>
            <th>Nama Menu</th>
            <th>Kategori</th>
            <th>Tipe Tampilan</th> {{-- <-- TAMBAHKAN HEADER INI --}}
            <th>Urutan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
                            {{-- Gunakan partial rekursif untuk menampilkan menu --}}
                            @forelse ($menus as $menu)
                                @include('menu._menu-item', ['menu' => $menu, 'level' => 0])
                          @empty
            <tr>
                {{-- Ubah colspan dari 4 menjadi 5 --}}
                <td colspan="5" class="text-center">Tidak ada data menu.</td>
            </tr>
        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
