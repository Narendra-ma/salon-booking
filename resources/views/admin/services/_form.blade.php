<div class="mb-3">
    <label for="name" class="form-label">Nama layanan</label>
    <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" maxlength="100"
           class="form-control @error('name') is-invalid @enderror" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea id="description" name="description" rows="3" maxlength="500"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-sm-6 mb-3">
        <label for="duration_minutes" class="form-label">Durasi (menit)</label>
        <input type="number" id="duration_minutes" name="duration_minutes" min="15" max="480" step="15"
               value="{{ old('duration_minutes', $service->duration_minutes) }}"
               class="form-control @error('duration_minutes') is-invalid @enderror" required>
        @error('duration_minutes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-sm-6 mb-3">
        <label for="price" class="form-label">Harga (Rp)</label>
        <input type="number" id="price" name="price" min="0" step="1000"
               value="{{ old('price', $service->price) }}"
               class="form-control @error('price') is-invalid @enderror" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
           @checked(old('is_active', $service->is_active))>
    <label class="form-check-label" for="is_active">Tampilkan di website dan bisa dibooking</label>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-salon">Simpan</button>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary rounded-pill">Batal</a>
</div>
