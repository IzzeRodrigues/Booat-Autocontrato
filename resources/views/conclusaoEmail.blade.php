@extends('padrao')

@section('titulo')
Email Enviado
@endsection


@section('conteudo')

<div class="col-6 bg-white shadow border border-2 rounded-4 d-flex flex-column justify-content-center align-items-center">
    <?php
        echo ("<p class='booat m-0 fs-1 mb-3 mt-5'>". $_REQUEST['resultado'] . "</p>")
    ?>
    <a class="col-2" href="/"><button class="botaoBooat rounded-2 col-12 botaoLogin my-5">Retornar</button></a>
</div>

@endsection