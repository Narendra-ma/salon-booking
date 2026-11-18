<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::withCount('bookings')->orderBy('name')->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create', ['service' => new Service(['is_active' => true])]);
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        Service::create($request->validated());

        return redirect()->route('admin.services.index')->with('success', 'Layanan ditambahkan.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->validated());

        return redirect()->route('admin.services.index')->with('success', 'Layanan diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->bookings()->exists()) {
            return back()->with('error', 'Layanan ini sudah punya booking dan tidak bisa dihapus. Nonaktifkan saja.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan dihapus.');
    }
}
