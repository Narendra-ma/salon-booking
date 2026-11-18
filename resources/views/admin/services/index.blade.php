@extends('layouts.admin')

@section('title', 'Layanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Layanan</h1>
        <a href="{{ route('admin.services.create') }}" class="btn btn-salon">Tambah Layanan</a>
    </div>

    <div class="card card-salon">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Durasi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td class="text-nowrap">{{ $service->durationLabel() }}</td>
                            <td class="text-nowrap">{{ $service->priceLabel() }}</td>
                            <td>
                                <span class="badge {{ $service->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline"
                                      onsubmit="return confirm('Hapus layanan {{ e($service->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $services->links() }}</div>
@endsection
