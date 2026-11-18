@extends('layouts.admin')

@section('title', 'Galeri')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Galeri Foto</h1>
    </div>

    <div class="card card-salon mb-4">
        <div class="card-body">
            <h2 class="h5">Tambah Foto</h2>
            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="photo" class="form-label">Foto</label>
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                               class="form-control @error('photo') is-invalid @enderror" required>
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG, atau WebP. Maksimal 5 MB.</div>
                    </div>
                    <div class="col-md-5">
                        <label for="title" class="form-label">Keterangan foto</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="150"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Contoh: Rias pengantin pelanggan">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-salon w-100">Unggah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        @forelse ($photos as $photo)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card card-salon h-100">
                    <img src="{{ $photo->url() }}" class="card-img-top" alt="{{ $photo->title ?: 'Foto galeri' }}"
                         style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <p class="small mb-3">{{ $photo->title ?: 'Tanpa keterangan' }}</p>
                        <form method="POST" action="{{ route('admin.gallery.destroy', $photo) }}"
                              onsubmit="return confirm('Hapus foto ini dari galeri?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-secondary py-4">Belum ada foto yang diunggah dari panel admin.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $photos->links() }}</div>
@endsection
