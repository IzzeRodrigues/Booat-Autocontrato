@extends('padrao')


@section('conteudo')

<form action="/chave" method="GET">
    <div class="d-flex flex-column align-items-center">
        <input type="text" name="nome" id="" placeholder="Nome" class="inputLogin col-12 my-2">
        <input type="text" name="numero" id="" placeholder="Número do Cartão" class="inputLogin col-12 my-2">
        <div>
            <input type="text" name="mes" id="" placeholder="Mês da validade" class="inputLogin my-2">
            <input type="text" name="ano" id="" placeholder="Ano da validade" class="inputLogin my-2">
        </div>
        <input type="text" name="cvv" id="" placeholder="CVV" class="inputLogin col-12 my-2">
    </div>
    <div class="d-flex justify-content-center">
        <input type="submit" class="botaoBooat rounded-2 col-3 botaoLogin mt-3">
    </div>
</form>

<script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

@endsection