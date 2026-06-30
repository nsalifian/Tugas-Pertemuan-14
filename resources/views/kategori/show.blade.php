@extends('layouts.app')

@section('title', 'Detail Kategori - ' . $kategori['nama'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">{{ $kategori['nama'] }}</li>
        </ol>
    </nav>

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0">{{ $kategori['nama'] }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Deskripsi:</strong> {{ $kategori['deskripsi'] }}</p>
            <p><strong>Jumlah Buku:</strong> {{ $kategori['jumlah_buku'] }}</p>
        </div>
    </div>

    <h4 class="mb-3">Daftar Buku dalam Kategori Ini</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku_list as $index => $buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $buku['judul'] }}</td>
                <td>{{ $buku['penulis'] }}</td>
                <td>{{ $buku['tahun'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
@endsection
