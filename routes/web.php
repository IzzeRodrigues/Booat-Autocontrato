<?php

use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\Paginacao;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controladorChave;
use App\Http\Controllers\EncriptacaoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\controladorPagamento;
use App\Models\BancoModel;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Paginacao::class, 'home'])->name('inicio');

//Route::get('/verificarUsuario', [BancoModel::class, 'verificarUsuario'])->name('verificarUsuario');
Route::get('/criarConta', [Paginacao::class, 'criarConta']);
Route::post('/verificarUsuario', [UsuariosController::class, 'verificarUsuario'])->name('verificarUsuario');

Route::middleware(\App\Http\Middleware\VerificaSessaoOperador::class)->group(function (){
    Route::get('/criarContrato', [Paginacao::class, 'criarContrato'])->name('criarContrato');
    Route::post('/pdfContrato', [ContratoController::class, 'index']);
    Route::get('/confirmarContrato', [Paginacao::class, 'confirmarContrato'])->name('confirmarContrato');
//Route::get('/salvarContrato', [BancoModel::class, 'create']);
    Route::get('/salvarContrato', [ContratoController::class, 'create']);
    Route::get('/enviarEmail', [EmailController::class, 'index'])->name('enviarEmail');
    Route::get('/conclusaoEmail', [Paginacao::class, 'conclusaoEmail'])->name('conclusaoEmail');
});

//Route::get('/assinarContrato', [BancoModel::class, 'index'])->name('assinarContrato');
Route::get('/assinarContrato/{controle_contrato}', [ContratoController::class, 'assinar'])->name('assinarContrato');
Route::middleware(\App\Http\Middleware\VerificaSessaoCliente::class)->group(function (){
    Route::get('/leituraContrato', [Paginacao::class, 'leituraContrato'])->name('leituraContrato');
    Route::get('/leituraContratoController', [ContratoController::class, 'leitura']);
    Route::get('/termos', [Paginacao::class, 'termos'])->name('termos');
    Route::post('/enviar-discrepancias', [ContratoController::class, 'enviarDiscrepancias']);

    Route::post('/bancoVerificacao', [ContratoController::class, 'verificarToken'])->name('verificarToken');

    Route::get('/pagamento', [Paginacao::class, 'pagamento'])->name('pagamento');
    Route::get('/credito', [Paginacao::class, 'credito'])->name('credito');
    Route::post('/pagar-com-cartao', [PagamentoController::class, 'pagarComCartao']);
    Route::post('/gerar-qr-code', [PagamentoController::class, 'gerarQRCode']);
//Route::get('/verificarPagamento', [PedidoController::class, 'verificarPagamento'])->name('verificarPagamento');
    Route::get('/verificarPagamento/{id_transacao}', [PagamentoController::class, 'consultarPagamento'])->name('verificarPagamento');
    Route::get('/conclusaoPagamento', [Paginacao::class, 'conclusaoPagamento'])->name('conclusaoPagamento');
});

/*
Route::get('/linkGerado', [Paginacao::class, 'linkGerado']);
Route::get('/soicitacaoConta', [Paginacao::class, 'solicitacaoConta']);
Route::get('/envioSMS', [Paginacao::class, 'envioSMS']);
Route::get('/cartao', [Paginacao::class, 'cartao']);
Route::get('/chave', [controladorChave::class, 'index']);
Route::get('/transicaoEncriptacao', [EncriptacaoController::class, 'index']);
//Route::get('/pedido', [PedidoController::class, 'index'])->name('pedido');
Route::get('/encriptacao', [Paginacao::class, 'encriptacao'])->name('encriptacao');
Route::get('/criadorContrato', [Paginacao::class, 'criadorContrato']);
Route::get('/leituraContratoController', [ContratoController::class, 'leitura']); //?
Route::get('/solicitarInformacoesContrato', [BancoModel::class, 'solicitarContrato'])->name('solicitarInformacoesContrato');
//Route::get('/salvarPagamento', [BancoModel::class, 'salvarPagamento'])->name('salvarPagamento');
Route::get('/dadosContratoAssinado', [BancoModel::class, 'dadosContratoAssinado'])->name('dadosContratoAssinado');
Route::get('/construcaoContratoAssinado', [ContratoController::class, 'contratoAssinado'])->name('contratoAssinado');
*/
