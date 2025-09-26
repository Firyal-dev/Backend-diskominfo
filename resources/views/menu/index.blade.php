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
                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Tabel Menu --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Kategori</th>
                                <th>Tipe Tampilan</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menus as $menu)
                                @include('menu._menu-item', ['menu' => $menu, 'level' => 0])
                            @empty
                                <tr>
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
