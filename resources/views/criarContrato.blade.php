@extends('padrao')

@section('titulo')
Criar Contrato
@endsection

@section('conteudo')

<p class="booat fs-2 mb-4">Insira os dados do contrato:</p>
<form class="col-12 col-lg-10 col-md-12 col-xl-8" action="/pdfContrato" method="POST" id="vmCriarContrato">
    @csrf
    <div class="d-flex flex-column align-items-center">
        <div class="col-12">
            <p class="m-0">Nome do Estabelecimento</p>
            <input type="text" name="nomeContratante" id="nomeContratante" class="inputLogin col-12" placeholder="Nome do Estabelecimento" value="{{ session('contrato_temporario.nomeContratante') }}">
        </div>
        <div class="row my-2 col-12">
            <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                <p class="m-0">CNPJ do Estabelecimento</p>
                <input type="text" name="cnpjContratante" id="cnpjContratante" class="inputLogin col-12" placeholder="CNPJ do Estabelecimento" value="{{ session('contrato_temporario.cnpjContratante') }}">
            </div>
            <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                <p class="m-0">Tipo de contrato</p>
                <select name="tipoEstabelecimento" id="tipoEstabelecimento" class="form-select inputLogin col-12">
                    <option {{ session('contrato_temporario.tipoEstabelecimento') == 'nautica' ? 'selected' : '' }} value="nautica">Náutica</option>
                    <option {{ session('contrato_temporario.tipoEstabelecimento') == 'marina' ? 'selected' : '' }} value="marina">Marina</option>
                    <option {{ session('contrato_temporario.tipoEstabelecimento') == 'autorizada' ? 'selected' : '' }} value="autorizada">Autorizada</option>
                </select>
            </div>
        </div>
        <div class="row my-2 col-12">
            <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                <p class="m-0">Nome do Representante</p>
                <input type="text" name="nomeRepresentante" id="nomeRepresentante" class="inputLogin col-12" placeholder="Nome do Representante" value="{{ session('contrato_temporario.nomeRepresentante') }}">
            </div>
            <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                <p class="m-0">CPF do Representante</p>
                <input type="text" name="cpfRepresentante" id="cpf" class="inputLogin col-12" placeholder="CPF do Representante" value="{{ session('contrato_temporario.cpfRepresentante') }}">
            </div>
        </div>
        <div class="row my-2 col-12">
            <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                <p class="m-0">Duração do serviço (em meses)</p>
                <input type="text" @keypress="somenteNumeros($event)" name="duracaoServico" id="duracaoServico" class="inputLogin col-12" placeholder="Duração" value="{{ session('contrato_temporario.duracaoServico') }}">
            </div>
            <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                <p class="m-0">Período de envio de mídias (em dias)</p>
                <input type="number" @keypress="somenteNumeros($event)" name="antecipacaoMidia" id="antecipacaoMidia" class="inputLogin col-12" placeholder="Dias" value="{{ session('contrato_temporario.antecipacaoMidia') }}">
            </div>
        </div>
        <form method="get" action=".">
            <div class="row my-2 col-12">
                <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                    <p class="m-0">Endereço do Estabelecimento</p>
                    <input type="text" name="enderecoContratante" id="endereco" class="inputLogin col-12" placeholder="Endereço" value="{{ session('contrato_temporario.enderecoContratante') }}">
                </div>
                <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                    <p class="m-0">Número do Estabelecimento</p>
                    <input type="text" name="numeroContratante" id="numeroContratante" class="inputLogin col-12" placeholder="Número" value="{{ session('contrato_temporario.numeroContratante') }}">
                </div>
            </div>
            <div class="row my-2 col-12">
                <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                    <p class="m-0">Bairro do Estabelecimento</p>
                    <input type="text" name="bairroContratante" id="bairro" class="inputLogin col-12" placeholder="Bairro" value="{{ session('contrato_temporario.bairroContratante') }}">
                </div>
                <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                    <p class="m-0">Cidade do Estabelecimento</p>
                    <input type="text" name="cidadeContratante" id="cidade" class="inputLogin col-12" placeholder="Cidade" value="{{ session('contrato_temporario.cidadeContratante') }}">
                </div>
            </div>
            <div class="row my-2 col-12">
                <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                    <p class="m-0">Unidade Federativa</p>
                    <select class="form-select inputLogin col-12" id="uf" name="uf">
                        <option {{ session('contrato_temporario.uf') == 'AC' ? 'selected' : '' }} value="AC">AC - Acre</option>
                        <option {{ session('contrato_temporario.uf') == 'AL' ? 'selected' : '' }} value="AL">AL - Alagoas</option>
                        <option {{ session('contrato_temporario.uf') == 'AP' ? 'selected' : '' }} value="AP">AP - Amapá</option>
                        <option {{ session('contrato_temporario.uf') == 'AM' ? 'selected' : '' }} value="AM">AM - Amazonas</option>
                        <option {{ session('contrato_temporario.uf') == 'BA' ? 'selected' : '' }} value="BA">BA - Bahia</option>
                        <option {{ session('contrato_temporario.uf') == 'CE' ? 'selected' : '' }} value="CE">CE - Ceará</option>
                        <option {{ session('contrato_temporario.uf') == 'DF' ? 'selected' : '' }} value="DF">DF - Distrito Federal</option>
                        <option {{ session('contrato_temporario.uf') == 'ES' ? 'selected' : '' }} value="ES">ES - Espirito Santo</option>
                        <option {{ session('contrato_temporario.uf') == 'GO' ? 'selected' : '' }} value="GO">GO - Goiás</option>
                        <option {{ session('contrato_temporario.uf') == 'MA' ? 'selected' : '' }} value="MA">MA - Maranhão</option>
                        <option {{ session('contrato_temporario.uf') == 'MT' ? 'selected' : '' }} value="MT">MT - Mato Grosso</option>
                        <option {{ session('contrato_temporario.uf') == 'MS' ? 'selected' : '' }} value="MS">MS - Mato Grosso do Sul</option>
                        <option {{ session('contrato_temporario.uf') == 'MG' ? 'selected' : '' }} value="MG">MG - Minas Gerais</option>
                        <option {{ session('contrato_temporario.uf') == 'PA' ? 'selected' : '' }} value="PA">PA - Pará</option>
                        <option {{ session('contrato_temporario.uf') == 'PB' ? 'selected' : '' }} value="PB">PB - Paraíba</option>
                        <option {{ session('contrato_temporario.uf') == 'PR' ? 'selected' : '' }} value="PR">PR - Paraná</option>
                        <option {{ session('contrato_temporario.uf') == 'PE' ? 'selected' : '' }} value="PE">PE - Pernambuco</option>
                        <option {{ session('contrato_temporario.uf') == 'PI' ? 'selected' : '' }} value="PI">PI - Piauí</option>
                        <option {{ session('contrato_temporario.uf') == 'RJ' ? 'selected' : '' }} value="RJ">RJ - Rio de Janeiro</option>
                        <option {{ session('contrato_temporario.uf') == 'RN' ? 'selected' : '' }} value="RN">RN - Rio Grande do Sul</option>
                        <option {{ session('contrato_temporario.uf') == 'RS' ? 'selected' : '' }} value="RS">RS - Rio Grande do Norte</option>
                        <option {{ session('contrato_temporario.uf') == 'RO' ? 'selected' : '' }} value="RO">RO - Rondônia</option>
                        <option {{ session('contrato_temporario.uf') == 'RR' ? 'selected' : '' }} value="RR">RR - Roraima</option>
                        <option {{ session('contrato_temporario.uf') == 'SC' ? 'selected' : '' }} value="SC">SC - Santa Catarina</option>
                        <option {{ session('contrato_temporario.uf') == 'SP' ? 'selected' : '' }} value="SP">SP - São Paulo</option>
                        <option {{ session('contrato_temporario.uf') == 'SE' ? 'selected' : '' }} value="SE">SE - Sergipe</option>
                        <option {{ session('contrato_temporario.uf') == 'TO' ? 'selected' : '' }} value="TO">TO - Tocantins</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                    <p class="m-0">CEP</p>
                    <input type="text" name="cep" id="cep" class="inputLogin col-12" placeholder="CEP" onblur="pesquisarCep(this.value)" value="{{ session('contrato_temporario.cep') }}">
                </div>
            </div>
        </form>

        <div class="row my-2 col-12">
            <div class="col-12 px-0">
                <p class="m-0">Email do Contratante</p>
                <input type="text" name="emailContratante" id="emailContratante" class="inputLogin col-12" placeholder="E-mail" value="{{ session('contrato_temporario.emailContratante') }}">
            </div>

        </div>
        <div class="row my-2 col-12">
            <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                <p class="m-0">Tempo de pagamento da rescisão (em dias)</p>
                <input type="number" @keypress="somenteNumeros($event)" name="tempoRescisao" id="tempoRescisao" class="inputLogin col-12" placeholder="Tempo de pagamento da rescisão" value="{{ session('contrato_temporario.tempoRescisao') }}">
            </div>
            <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                <p class="m-0">Valor da rescisão (em porcentagem)</p>
                <input type="text" name="valorRescisao" id="valorRescisao" class="inputLogin col-12" placeholder="Valor da rescisão" value="{{ session('contrato_temporario.valorRescisao') }}">
            </div>
        </div>
        <div class="col-12 row my-2">
            <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                <p class="m-0">Tipo de Plano</p>
                <input type="text" name="tipoPlano" id="tipoPlano" class="inputLogin col-12" placeholder="Tipo de plano" value="{{ session('contrato_temporario.tipoPlano') }}">
            </div>
            <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                <p class="m-0">Validade do Contrato (em meses)</p>
                <input type="number" @keypress="somenteNumeros($event)" name="validadeContrato" id="validadeContrato" class="inputLogin col-12" placeholder="Validade" value="{{ session('contrato_temporario.validadeContrato') }}">
            </div>
        </div>
        <div class="col-12 row my-2">
            <div class="col-12 col-md-6 px-0 pe-md-2 ps-md-0">
                <p class="m-0">Valor do contrato</p>
                <input type="text" name="valor" id="valor" class="inputLogin col-12" placeholder="Valor" value="{{ session('contrato_temporario.valor') }}">
            </div>
            <div class="col-12 col-md-6 px-0 pe-md-0 ps-md-2">
                <label>Parcelas</label>
                <select class="form-select inputLogin col-12" name="parcelas" id="parcelas">
                    <option {{ session('contrato_temporario.parcelas') == '1' ? 'selected' : '' }} value="1">1</option>
                    <option {{ session('contrato_temporario.parcelas') == '2' ? 'selected' : '' }} value="2">2</option>
                    <option {{ session('contrato_temporario.parcelas') == '3' ? 'selected' : '' }} value="3">3</option>
                </select>
            </div>
        </div>
        <div class="col-12 d-flex flex-row justify-content-center mt-4">
            <a class="col-3">
                <button @click="verificarCampos($event)" type="submit" class="botaoBooat botaoLogin rounded-2 col-12">Continuar</button>
            </a>
        </div>
    </div>
</form>

<?php

    if (isset($_REQUEST['erro']))
    {
        echo ("<script type='text/javascript'>alert('" . $_REQUEST['erro'] ."')</script>");
    }

?>

<script src="{{ asset('js/viacep.js') }}" type="text/javascript"></script>
<script type="module" src="{{ asset('js/criar-contrato.js') }}" type="text/javascript"></script>

@component('components.modal.modal')
    @slot('id_modal', 'ModalCamposObrigatorios')
    @slot('titulo_modal', 'Erro')
    @slot('corpo_modal', 'Todos os campos do contrato são obrigatórios.')
    @slot('botoes_modal')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
    @endslot
@endcomponent

@component('components.modal.modal')
    @slot('id_modal', 'ErroModal')
    @slot('titulo_modal', 'Erro')
    @slot('corpo_modal')
        @{{ mensagem_erro }}
    @endslot
    @slot('botoes_modal')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
    @endslot
@endcomponent

@endsection
