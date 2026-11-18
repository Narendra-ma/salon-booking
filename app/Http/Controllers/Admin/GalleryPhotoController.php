<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryPhotoRequest;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryPhotoController extends Controller
{
    public function index(): View
    {
        $photos = GalleryPhoto::latest()->paginate(12);

        return view('admin.gallery.index', compact('photos'));
    }

    public function store(GalleryPhotoRequest $request): RedirectResponse
    {
        $path = $request->file('photo')->store('gallery', 'public');

        GalleryPhoto::create([
            'path' => $path,
            'title' => $request->validated('title'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function destroy(GalleryPhoto $gallery): RedirectResponse
    {
        Storage::disk('public')->delete($gallery->path);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil dihapus.');
    }
}
