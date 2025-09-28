<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvisoController;
use App\Http\Controllers\Api\CronogramaController;
use App\Http\Controllers\Api\DepoimentoController;
use App\Http\Controllers\Api\DocumentoController;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\MsgContatoController;
use App\Http\Controllers\Api\PatrocinadorController;
use App\Http\Controllers\Api\MidiaController;
use App\Http\Controllers\Api\PhotoGalleryController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\SobreController;
use App\Http\Controllers\Api\PresidenteController;
use App\Http\Controllers\Api\LocalPhotoController;
use App\Http\Controllers\Api\AtividadeController;
use App\Http\Controllers\Api\AtividadePhotoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- ROTAS PÚBLICAS (Qualquer um pode acessar) ---

Route::post('/login', [AuthController::class, 'login']);
Route::post('/contato', [MsgContatoController::class, 'store']);
Route::get('/avisos', [AvisoController::class, 'index']);
Route::get('/depoimentos', [DepoimentoController::class, 'index']);
Route::get('/eventos', [EventoController::class, 'index']);
Route::get('/patrocinadores', [PatrocinadorController::class, 'index']);
Route::get('/cronograma', [CronogramaController::class, 'getLatest']);
Route::get('/documentos', [DocumentoController::class, 'index']);
Route::get('/galleries', [PhotoGalleryController::class, 'index']);
Route::get('/sobre', [SobreController::class, 'show']);
Route::get('/presidentes', [PresidenteController::class, 'index']);
Route::get('/local-photos', [LocalPhotoController::class, 'index']);
Route::get('/atividades', [AtividadeController::class, 'index']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});


// --- ROTAS PROTEGIDAS (Apenas usuários logados podem acessar) ---

Route::middleware('auth:sanctum')->group(function () {

    // Autenticação
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- Gerenciamento (CRUDs dos Dashboards) ---

    // Usamos 'except' para não recriar a rota de listagem 'index', que já definimos como pública
    Route::apiResource('avisos', AvisoController::class)->except(['index']);
    Route::apiResource('depoimentos', DepoimentoController::class)->except(['index']);
    Route::apiResource('eventos', EventoController::class)->except(['index']);
    Route::apiResource('patrocinadores', PatrocinadorController::class)->except(['index']);
    Route::apiResource('midias', MidiaController::class);
    Route::apiResource('galleries', PhotoGalleryController::class)->except(['index', 'show', 'update']);
    Route::apiResource('presidentes', PresidenteController::class)->except(['index']);
    Route::apiResource('atividades', AtividadeController::class)->except(['index']);

    Route::post('/conteudo-pagina-sobre', [SobreController::class, 'update']);
    
    // CORREÇÃO AQUI: Aplicando o mesmo padrão para Documentos
    Route::apiResource('documentos', DocumentoController::class)->except(['index']);

    // Gerenciamento de Mensagens de Contato
    Route::get('/mensagens', [MsgContatoController::class, 'index']);
    Route::put('/mensagens/{mensagem}/read', [MsgContatoController::class, 'markAsRead']);
    Route::delete('/mensagens/{mensagem}', [MsgContatoController::class, 'destroy']);
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy']);

    // Upload do Cronograma
    Route::post('/cronograma', [CronogramaController::class, 'upload']);
    Route::post('/atividades/{atividade}/photos', [AtividadePhotoController::class, 'store']);

    Route::post('/local-photos', [LocalPhotoController::class, 'store']);
    Route::delete('/local-photos/{photo}', [LocalPhotoController::class, 'destroy']);
    Route::delete('/atividade-photos/{photo}', [AtividadePhotoController::class, 'destroy']);
});
