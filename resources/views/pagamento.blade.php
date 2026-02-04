@extends('padraoCliente')

@section('conteudo')

         <main class="col-12" id="vmPagamentoPix">
            <div class="container mt-5 d-flex flex-column">
                <h3 class="text-center booat">Realize o pagamento contratual</h3>
                <div class="col-12 col-md-6 d-flex align-self-center">
                    <div class=" d-flex shadow rounded-4 p-5 mt-5 my-auto card-body flex-column">
                        <h4 class="booat text-center" :class="qr_code_image === '' ? '' : 'oculto' ">Escolha o Método de pagamento:</h4>
                        <div class="d-flex justify-content-center col-12" style="min-height: 100px;">
                            <form id="form" class="d-flex flex-column align-items-center col-12 col-md-10 py-2">

                                @csrf

                                <div>
                                    <input type="hidden" placeholder="João Rodrigues Santos Silva" name="nomeComprador" id="nomeComprador" value="{{ session('contrato_para_assinar.nomeContratante') }}">
                                    <input type="hidden" placeholder="Estabelecimento do João" name="nomeEstabelecimento" id="nomeEstabelecimento" value="{{ session('contrato_para_assinar.nomeEstabelecimento') }}">
                                    <input type="hidden" placeholder="XXX.XXX.XXX-XX" name="numDocumento" id="numDocumento" value="{{ session('contrato_para_assinar.cnpjContratante') }}">
                                    <input type="hidden" placeholder="estabelecimento@email.com" name="endEmail" id="endEmail" value="{{ session('contrato_para_assinar.emailContratante') }}">
                                    <input type="hidden" name="controleContrato" id="controleContrato" value="{{ session('contrato_para_assinar.controleContrato') }}">
                                </div>

                                <p style="display: none" id="teste" class="m-0 mt-4">Aproxime a Câmera do celular</p>
                                <img src="images/qr.jpg" id="minhaImagem" style="display: none" width="65%">

                                <div :class="qr_code_image === '' ? 'oculto' : '' ">
                                    <p id="teste" class="m-0 mt-4 text-center">Aproxime a Câmera do celular</p>
                                    <img :src="qr_code_image" alt="">
                                </div>

                                <div :class="qr_code_image === '' ? 'oculto' : '' ">
                                    <div class="mt-1"></div>
                                    <div class="text-center">Após o pagamento, você será redirecionado automáticamente para a tela de conclusão.</div>
                                    <div class="mt-2"></div>
                                </div>


                                <p style="display: none" id="teste2" >CNPJ 24.661.945/0001-12</p>
                                <div class="row col-12">

                                    <div class="col-12 col-md-6 my-md-0 my-3">
                                        <input @click="gerarQRCode" class="pix botaoBooat botaoLogin rounded-2 col-12" type="button" value="PIX" id="teste"/>
                                    </div>

                                    <div class="col-12 col-md-6 my-md-0 my-3">
                                        <a class="col-12 p-0" href="/credito?<?php echo($_SERVER['QUERY_STRING'])?>"><button type="button" class="botaoBooat botaoLogin rounded-2 col-12">Cartão de crédito</button></a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
         <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

        <script src="{{ asset('js/script.js') }}"></script>
        <script type="module" src="{{ asset('js/pagamentoPix.js') }}"></script>

    @component('components.modal.modal')
        @slot('id_modal', 'ModalGerandoQRCode')
        @slot('titulo_modal', 'Aguarde')
        @slot('corpo_modal', 'Gerando QR Code, por favor aguarde...')
        @slot('botoes_modal', '')
    @endcomponent

@endsection
