<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMsgContatoRequest;
use App\Models\MsgContato;
use App\Http\Resources\MsgContatoResource;
use Illuminate\Support\Facades\DB;

class MsgContatoController extends Controller
{
    public function index()
    {
        $mensagens = MsgContato::latest('msgContato_id')->get();
        return MsgContatoResource::collection($mensagens);
    }

    public function markAsRead(MsgContato $mensagem)
    {
        $mensagem->update(['msgContato_read' => true]);
        return new MsgContatoResource($mensagem);
    }

    public function destroy(MsgContato $mensagem)
    {
        $idParaApagar = $mensagem->msgContato_id;

        $linhasDeletadas = DB::table('msgContato')->where('msgContato_id', $idParaApagar)->delete();

        if ($linhasDeletadas > 0) {
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'O registro não foi encontrado no banco de dados para ser deletado.'], 404);
        }
    }

    public function store(StoreMsgContatoRequest $request)
    {
        $mensagem = MsgContato::create($request->validated());
        return response()->json(new MsgContatoResource($mensagem), 201);
    }
}