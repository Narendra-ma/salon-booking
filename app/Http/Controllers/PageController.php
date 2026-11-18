<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\GalleryPhoto;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $services = Service::active()->orderBy('name')->take(6)->get();

        return view('pages.home', compact('services'));
    }

    // Foto galeri diambil dari folder public/images/gallery, jadi pemilik
    // cukup menambah file di sana tanpa mengubah kode.
    public function gallery(): View
    {
        $photos = collect(File::files(public_path('images/gallery')))
            ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp', 'svg']))
            ->sortBy(fn ($file) => $file->getFilename(), SORT_NATURAL)
            ->map(fn ($file) => asset('images/gallery/'.$file->getFilename()))
            ->values();

        $uploadedPhotos = GalleryPhoto::latest()->get()->map(fn ($photo) => [
            'url' => $photo->url(),
            'title' => $photo->title,
        ]);

        $photos = $uploadedPhotos->concat($photos->map(fn ($url) => ['url' => $url, 'title' => null]))->values();

        return view('pages.gallery', compact('photos'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }
}
