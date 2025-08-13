<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use App\Http\Resources\PhotoGalleryResource;
use Illuminate\Support\Facades\Storage;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        $galleries = PhotoGallery::with('photos')->latest()->get();
        return PhotoGalleryResource::collection($galleries);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $gallery = PhotoGallery::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        foreach ($request->file('photos') as $photoFile) {
            $path = $photoFile->store('galleries', 'public_uploads');
            $gallery->photos()->create(['path' => $path]);
        }

        return new PhotoGalleryResource($gallery->load('photos'));
    }

    public function destroy(PhotoGallery $photoGallery)
    {
        foreach ($photoGallery->photos as $photo) {
            Storage::disk('public_uploads')->delete($photo->path);
        }

        $photoGallery->delete();
        return response()->json(null, 204);
    }
}