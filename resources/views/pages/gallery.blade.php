@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow mb-2">Galeri</p>
                <h1 class="h2">Hasil Kerja &amp; Suasana Salon</h1>
            </div>

            @if ($photos->isEmpty())
                <p class="text-center text-secondary">Foto belum tersedia.</p>
            @else
                <div class="row g-3">
                    @foreach ($photos as $photo)
                        <div class="col-6 col-md-4 col-lg-3">
                            <button type="button" class="gallery-thumb ratio ratio-1x1" data-bs-toggle="modal"
                                    data-bs-target="#photoModal" data-photo="{{ $photo['url'] }}"
                                    data-title="{{ $photo['title'] }}" aria-label="Perbesar foto {{ $photo['title'] ?: $loop->iteration }}">
                                <img src="{{ $photo['url'] }}" alt="{{ $photo['title'] ?: 'Foto galeri '.$loop->iteration }}" loading="lazy">
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <div class="modal fade" id="photoModal" tabindex="-1" aria-label="Foto diperbesar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-transparent">
                <img id="photoModalImage" src="" alt="Foto diperbesar" class="img-fluid rounded-4" data-bs-dismiss="modal">
                <p id="photoModalTitle" class="text-white text-center mt-2 mb-0"></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('photoModal').addEventListener('show.bs.modal', function (event) {
            document.getElementById('photoModalImage').src = event.relatedTarget.dataset.photo;
            document.getElementById('photoModalTitle').textContent = event.relatedTarget.dataset.title || '';
        });
    </script>
@endpush
