@extends('padrao')

@section('titulo')
Criar Conta
@endsection

@section('conteudo')

<div class="ParteSuperiorCriarConta">
    <p class="mb-5 fs-2 booat">Crie seu cadastro de operador do sistema:</p>
</div>
<div class="ParteInferiorCriarConta col-6">
    <form action="/solicitacaoConta" method="GET" class="col-12">
        <div>
            <div class="row">
                <div class="d-flex flex-column col-6">
                    <p class="m-0">CPF</p>
                    <input type="text" name="cpf" id="" class="inputLogin">
                </div>
                <div class="d-flex flex-column col-6">
                    <p class="m-0">E-Mail</p>
                    <input type="text" name="correioEletronico" id="" class="inputLogin">
                </div>
            </div>
            <div class="d-flex flex-column mt-3">
                <p class="m-0">Identificação</p>
                <input type="text" name="nome" id="" class="inputLogin">
            </div>
        </div>
        <div class="mt-4 justify-content-center d-flex flex-row">
            <a class="col-4">
                <input type="submit" value="Enviar" class="botaoBooat botaoLogin col-12 rounded-2">
            </a>
        </div>
</div>
</form>

@endsection