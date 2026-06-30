@extends('layouts.app')

@section('title', 'Daftar Kategori Buku')

@section('content')
    <h1 class="mb-4">Daftar Kategori Buku</h1>

    <div class="row">
        @foreach ($kategori_list as $kategori)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $kategori['nama'] }}</h5>
                    <p class="card-text">{{ $kategori['deskripsi'] }}</p>
                    <p class="card-text"><strong>Jumlah Buku:</strong> {{ $kategori['jumlah_buku'] }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
