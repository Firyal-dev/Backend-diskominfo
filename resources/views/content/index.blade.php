@extends('layouts.dashboard')

@section('content')
<section class="section">
    @include('content.header')
    <div class="row">
        <div class="col-12">
            <div class="card" x-data="{ view: 'galeri', albumId: null }">

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

                    {{-- FOTO DALAM ALBUM --}}
                    <div x-show="view === 'album-photos'">
                        @include('content.album.photos_album')
                    </div>

                    {{-- MODAL TAMBAH GALERI --}}
                    @include('content.galeri.modal_tambah_galeri')

                    {{-- MODAL BUAT ALBUM --}}
                    @include('content.album.modal_buat_album')

                    {{-- MODAL TAMBAH FOTO KE ALBUM --}}
                    @include('content.album.modal_upload_photos_album')

                </div>

            </div>
        </div>
    </div>
</section>
@endsection