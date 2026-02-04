@extends('padraoCliente')

@section('titulo')
Conclusão
@endsection

@section('conteudo')

<div class="col-7 bg-white border-2 p-5 rounded-4 d-flex flex-column justify-content-center align-items-center">
    <p class="booat fs-3 text-center">Contrato registrado com sucesso</p>
    <p class="text-center">Agradecemos por confiar a sua embarcaçãoem em nossos cuidados</p>

    <img src="{{ asset('images/booat.png') }}" width="450"/>

    <a class="col-5 mt-3" href="https://booat.io"><button class="botaoBooat botaoLogin col-12 rounded-2">Sair</button></a>
    <!--<a class="col-5 mt-3" href="https://booat.io"><button class="botaoBooat botaoLogin col-12 rounded-2">Agendar Reunião</button></a>-->
</div>

@endsection
