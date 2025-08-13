<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function destroy(Photo $photo)
    {
        Storage::disk('public_uploads')->delete($photo->path);

        $photo->delete();

        return response()->json(null, 204);
    }
}