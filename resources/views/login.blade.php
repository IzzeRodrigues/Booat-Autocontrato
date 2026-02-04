@extends('padrao')

@section('titulo')
Início
@endsection

@section('conteudo')

<div>
    <p class="fs-2 text-center booat">Olá! Identifique-se para operar o sistema:</p>
</div>
<div class="col-6">
    <form action="/verificarUsuario" method="POST" id="vmLogin">
        @csrf
        <div class="my-4">
            <input type="text" name="usuario" id="" class="col-12 my-2 inputLogin" placeholder="Insira seu email">
            <input type="password" name="senha" id="" class="col-12 my-2 inputLogin" placeholder="Insira sua senha">
        </div>
        <div class="align-items-center justify-content-center d-flex flex-column">
            <a href="/criarConta" class="m-0 mb-2 booat text-decoration-none">Não possuo cadastro</a>
            <input type="submit" value="Validar dados" class="botaoBooat botaoLogin col-7 rounded-2">
        </div>
    </form>
</div>

<script src="{{ asset('js/login.js') }}"></script>

@component('components.modal.modal')
    @slot('id_modal', 'LoginModal')
    @slot('titulo_modal', 'Erro')
    @slot('corpo_modal', 'Usuário e/ou senha incorreto.');
    @slot('botoes_modal')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
    @endslot
@endcomponent

@endsection
