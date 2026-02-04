@extends('padraoCliente')



@section('conteudo')

<main class="col-10" id="vmPagamentoCartao">
    <div class="container d-flex justify-content-center mt-5 col-10">
        <form method="POST" class="col-md-7 col-11" action="/chave">
            @csrf
            <div class="col-12">
                <div>
                    <label class="justify-content-start d-flex">Insira seu nome completo</label>
                    <input class="form-control form-control-md" type="text" placeholder="João Rodrigues Santos Silva" name="nomeComprador" id="nomeComprador">
                </div>
                <div>
                    <label class="justify-content-start d-flex">Insira o nome do estabelecimento</label>
                    <input class="form-control form-control-md" type="text" placeholder="Estabelecimento do João" name="nomeEstabelecimento" id="nomeEstabelecimento">
                </div>

                <div class="d-flex justify-content-around col-12">
                    <div class="col-6 d-flex flex-column align-items-center">
                        <label class="text-center">CPF ou CNPJ</label>
                        <input @keypress="mascaraCPF_CNPJ" class="form-control form-control-md" type="text" placeholder="XXX.XXX.XXX-XX" name="numDocumento" id="numDocumento">
                    </div>
                    <div class="col-6 d-flex flex-column align-items-center">
                        <label>Insira o Email</label>
                        <input class="form-control form-control-md" type="text" placeholder="estabelecimento@email.com" name="endEmail" id="endEmail">
                    </div>
                </div>

                <input type="hidden" name="controleContrato" id="controleContrato" value="{{ session('contrato_para_assinar.controleContrato') }}">
            </div>

            <div class="col-12 mt-5">
                <div class="d-flex flex-column">
                    <label class="d-flex justify-content-start">Insira o nome presente no cartão</label>
                    <input class="form-control form-control-md" type="text" placeholder="João R S Silva" name="nomeCartao" id="nomeCartao">
                </div>
                <div>
                    <label class="d-flex justify-content-start">Insira o número do cartão</label>
                    <input class="form-control form-control-md" type="text" placeholder="XXXX XXXX XXXX XXXX" name="numCartao" id="numCartao">
                </div>

                <div class="container p-0">
                    <div class="row d-flex justify-content-between">
                        <div class="col-6 d-flex flex-column align-items-center">
                            <label>CVV</label>
                            <input class="form-control form-control-md" type="text" placeholder="123" name="cvv" id="cvv">
                        </div>
                        <div class="col-6  d-flex flex-column align-items-center">
                            <label>Data de Validade</label>
                            <div class="d-flex justify-content-between col-12">
                                <select class="form-select" name="mes" id="mes">
                                    <option selected></option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select class="form-select" name="ano" id="ano">
                                    <option selected></option>
                                    <option value="2023">23</option>
                                    <option value="2024">24</option>
                                    <option value="2025">25</option>
                                    <option value="2026">26</option>
                                    <option value="2027">27</option>
                                    <option value="2028">28</option>
                                    <option value="2029">29</option>
                                    <option value="2030">30</option>
                                    <option value="2031">31</option>
                                    <option value="2032">32</option>
                                    <option value="2033">33</option>
                                    <option value="2034">34</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    <button @click="pagar" type="button" class="botaoBooat botaoLogin rounded-2 mt-4 col-5">Pagar</button>
                </div>
            </div>
            <input type="hidden" value="<?php echo($_REQUEST['contrato'])?>" name="contrato">
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script type="module" src="{{ asset('js/pagamentoCartao.js') }}"></script>

@component('components.modal.modal')
    @slot('id_modal', 'ModalRealizandoPagamento')
    @slot('titulo_modal', 'Aguarde')
    @slot('corpo_modal', 'Realizando pagamento, por favor aguarde...')
    @slot('botoes_modal', '')
@endcomponent

<?php

    if(isset($_REQUEST['mensagem']))
    {
        echo("<script type='text/javascript'>alert('Pagamento não concluído, erro: " . $_REQUEST['mensagem'] . "')</script>");
    }

?>

@endsection
