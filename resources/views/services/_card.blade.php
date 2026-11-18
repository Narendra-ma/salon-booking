<div class="card card-salon h-100">
    <div class="card-body d-flex flex-column p-4">
        <h3 class="h5">{{ $service->name }}</h3>
        <p class="flex-grow-1">{{ $service->description }}</p>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="price">{{ $service->priceLabel() }}</span>
            <span class="small text-secondary"><i class="bi bi-clock me-1"></i>{{ $service->durationLabel() }}</span>
        </div>
        <a href="{{ route('booking.create', ['layanan' => $service->id]) }}" class="btn btn-salon-outline btn-sm">Pesan Layanan Ini</a>
    </div>
</div>
