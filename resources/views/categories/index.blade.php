@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Kategori</h3>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST" class="row g-2">
            @csrf
            <div class="col-md-9">
                <input type="text" name="nama_kategori" class="form-control" placeholder="Input Nama Kategori Baru..." required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">+ Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $cat)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $cat->nama_kategori }}</td>
                    <td>
                         <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-warning btn-sm">Edit</a> 
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection