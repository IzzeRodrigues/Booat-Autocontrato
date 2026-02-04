@extends('padrao')

@section('titulo')
Link Pronto
@endsection

@section('conteudo')

<p class="booat fs-1">Contrato Gerado!</p>
<p class="textoCinza fs-5">Clique no link abaixo para enviar ao cliente</p>
<div class="caixaLinkGerado rounded-5 col-5 pt-5 d-flex align-items-center flex-column">
    <p class="m-0 col-11">Link para assinatura do contrato:</p>
    <label class="row localLink col-11 m-0 rounded-2 align-items-center d-flex py-1">
        <p class="col-10 m-0">Links</p>
        <div class="col-2 d-flex flex-row justify-content-end">
            <button class="rounded-2 botaoLink col-7"><img src="images/link.png" class="img-fluid"></button>
        </div>
    </label>
    <p class="m-0 col-11 textoCinza fs-6 mb-4">Clique no botão para copiar o link</p>
    <a class="col-4" href="/">
        <button class="botaoBooat col-12 rounded-2 mb-4">Gerar Contrato</button>
    </a>
    <p class="mx-4 text-justify fs-6">Obs.: Contrato gerado, o cliente citaro irá receber um e-mail com o link acima e um token de autenticação, o qual deverá ser apresentado no momento da assinatura do contrato.</p>
</div>

@endsection