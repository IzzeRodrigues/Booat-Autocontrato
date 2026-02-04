@extends('padraoCliente')

@section('titulo')
Conclusão
@endsection

@section('conteudo')

<div class="col-7 bg-white shadow border border-2 p-5 rounded-4 d-flex flex-column justify-content-center align-items-center">
    <p class="booat fs-3 text-center">Pagamento concluido com sucesso, obrigado por escolher a Booat para colocar o seu negócio no mapa!</p>
    <object data="contrato.pdf" type="application/pdf" class="localContrato col-12">
        <embed style="position:absolute;">
    </object>   
    <a class="col-5 mt-3" href="https://booat.io"><button class="botaoBooat botaoLogin col-12 rounded-2">Ir ao site principal</button></a>
</div>

@endsection