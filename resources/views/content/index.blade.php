@extends('layouts.dashboard')

@section('content')
<div
    class="page-heading">
    @include('content.header')

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card" x-data="{ view: 'galeri' }">

                    {{-- TOOLBAR --}}
                    @include('content.toolbar')

                    <div class="card-body">

                        {{-- GALERI --}}
                        <div x-show="view === 'galeri'">
                            @include('content.galeri.galeri')
                        </div>

                        {{-- ALBUM --}}
                        <div x-show="view === 'album'">
                            @include('content.album.album')
                        </div>

                        {{-- TAMBAH GALERI --}}
                        @include('content.galeri.modal_tambah_galeri')
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection