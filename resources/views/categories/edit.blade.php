@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kategori</h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="{{ $category->nama_kategori }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Kategori</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection