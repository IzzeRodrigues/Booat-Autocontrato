<?php
?>

@extends('padrao')

@section('titulo')
Confirmação
@endsection

@section('conteudo')

<p class="fs-2 booat">Confirme as informações</p>
    <object data="{{ $dominio == 'localhost' ? public_path('/contratos/'.session('arquivo_contrato_temporario.filename')) : 'contratos/'.session('arquivo_contrato_temporario.filename') }}" type="application/pdf" class="localContrato col-8">
        <embed style="position:absolute;">
    </object>
<div class="mt-5 col-10 d-flex justify-content-center">
    <a class="col-3 me-4" href="/criarContrato">
        <button class="botaoBooat botaoLogin col-12 rounded-2">Revisar informações</button>
    </a>
    <?php
        echo ("<a class='col-3 ms-4' href='/salvarContrato'>
        <button class='botaoBooat botaoLogin col-12 rounded-2'>Finalizar e enviar ao cliente</button>
    </a>")


    ?>

</div>

@endsection
