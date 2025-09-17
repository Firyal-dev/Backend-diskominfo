@extends('layouts.dashboard')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Agenda</h3>
                    <p class="text-subtitle text-muted">Daftar semua agenda yang telah dijadwalkan.</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('agenda.create') }}" class="btn btn-primary">Tambah Agenda Baru</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Agenda</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agendas as $agenda)
                                <tr>
                                    <td>{{ $loop->iteration + $agendas->firstItem() - 1 }}</td>
                                    <td>{{ $agenda->agenda }}</td>
                                    <td>{{ $agenda->tanggal->format('d F Y') }}</td>
                                    <td>
                                        <a href="{{ route('agenda.edit', $agenda->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data agenda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $agendas->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
