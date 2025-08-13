<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentoResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentoController extends Controller
{
    public function index()
    {
        return DocumentoResource::collection(Documento::latest('docs_id')->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'docs_title' => 'required|string|max:255',
            'docs_number' => 'required|string|max:50',
            'docs_date' => 'required|date',
            'docs_types' => ['required', \Illuminate\Validation\Rule::in(['Ofício', 'Ata'])],
            'docs_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $request->file('docs_file')->store('documentos', 'public_uploads');

        try {
            $id = \DB::table('docs')->insertGetId([
                'docs_title' => $validatedData['docs_title'],
                'docs_number' => $validatedData['docs_number'],
                'docs_date' => $validatedData['docs_date'],
                'docs_types' => $validatedData['docs_types'],
                'docs_file' => $path,
            ]);

            $novoDocumento = \App\Models\Documento::find($id);

            return new \App\Http\Resources\DocumentoResource($novoDocumento);

        } catch (\Exception $e) {
            Storage::disk('public_uploads')->delete($path);

            return response()->json([
                'message' => 'Ocorreu um erro ao salvar o documento no banco de dados.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Documento $documento)
    {
        $validatedData = $request->validate([
            'docs_title' => 'required|string|max:255',
            'docs_number' => 'required|string|max:50',
            'docs_date' => 'required|date',
            'docs_types' => ['required', Rule::in(['Ofício', 'Ata'])],
            'docs_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('docs_file')) {
            if ($documento->docs_file) {
                Storage::disk('public_uploads')->delete($documento->docs_file);
            }
            $path = $request->file('docs_file')->store('documentos', 'public_uploads');
            $validatedData['docs_file'] = $path;
        }

        $documento->update($validatedData);
        return new DocumentoResource($documento);
    }

    public function destroy(Documento $documento)
    {
        if ($documento->docs_file) {
            Storage::disk('public_uploads')->delete($documento->docs_file);
        }
        $documento->delete();
        return response()->json(null, 204);
    }
}