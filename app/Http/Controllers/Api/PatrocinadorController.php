<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PatrocinadorController extends Controller
{
    public function index()
    {
        $patrocinadores = DB::table('patrocinadores')->get();

        $formatted = $patrocinadores->map(function ($item) {
            return [
                'id' => $item->patrocinadores_id,
                'name' => $item->patrocinadores_name,
                'url' => $item->patrocinadores_url,
                'logo' => $item->patrocinadores_logo ? Storage::disk('public_uploads')->url($item->patrocinadores_logo) : null,
            ];
        });

        return response()->json($formatted);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patrocinadores_name' => 'required|string|max:255',
            'patrocinadores_url' => 'required|url',
            'patrocinadores_logo' => 'required|image|max:2048',
        ]);

        $path = $request->file('patrocinadores_logo')->store('patrocinadores', 'public_uploads');

        $id = DB::table('patrocinadores')->insertGetId([
            'patrocinadores_name' => $validatedData['patrocinadores_name'],
            'patrocinadores_url' => $validatedData['patrocinadores_url'],
            'patrocinadores_logo' => $path,
        ], 'patrocinadores_id');

        $novoPatrocinador = DB::table('patrocinadores')->find($id);

        return response()->json($novoPatrocinador, 201);
    }

    public function update(Request $request, string $id)
    {
        $patrocinador = DB::table('patrocinadores')->where('patrocinadores_id', $id)->first();

        if (!$patrocinador) {
            return response()->json(['message' => 'Patrocinador não encontrado.'], 404);
        }

        $validatedData = $request->validate([
            'patrocinadores_name' => 'required|string|max:255',
            'patrocinadores_url' => 'required|url',
            'patrocinadores_logo' => 'nullable|image|max:2048',
        ]);

        $updateData = [
            'patrocinadores_name' => $validatedData['patrocinadores_name'],
            'patrocinadores_url' => $validatedData['patrocinadores_url'],
        ];

        if ($request->hasFile('patrocinadores_logo')) {
            if ($patrocinador->patrocinadores_logo) {
                Storage::disk('public_uploads')->delete($patrocinador->patrocinadores_logo);
            }
            $path = $request->file('patrocinadores_logo')->store('patrocinadores', 'public_uploads');
            $updateData['patrocinadores_logo'] = $path;
        }

        DB::table('patrocinadores')->where('patrocinadores_id', $id)->update($updateData);

        $patrocinadorAtualizado = DB::table('patrocinadores')->find($id);
        return response()->json($patrocinadorAtualizado);
    }

    public function destroy(string $id)
    {
        $patrocinador = DB::table('patrocinadores')->where('patrocinadores_id', $id)->first();

        if ($patrocinador) {
            if ($patrocinador->patrocinadores_logo) {
                Storage::disk('public_uploads')->delete($patrocinador->patrocinadores_logo);
            }
            DB::table('patrocinadores')->where('patrocinadores_id', $id)->delete();
        }

        return response()->json(null, 204);
    }
}