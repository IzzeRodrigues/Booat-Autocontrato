@extends('padraoCliente')

@section('titulo')
Confirmação
@endsection

@section('conteudo')

    <div class="col-8" id="vmLeituraContrato">
        <p class="fs-2 booat text-center">Leia e Confirme as informações do contrato abaixo:</p>

        <object data="{{
            $dominio == 'localhost' ?
                public_path('/contratos/'.(!empty(session('contrato_temporario')) ? session('contrato_temporario.filename') : session('contrato_para_assinar.filename')))
                : 'contratos/'.(!empty(session('contrato_temporario')) ? session('contrato_temporario.filename') : session('contrato_para_assinar.filename'))
                }}"
                type="application/pdf" class="localContrato col-12">
            <embed style="position:absolute;">
        </object>

        <div class="mt-5 col-12 d-flex justify-content-center">

            <button class="botaoBooat botaoLogin col-3 me-4 rounded-2" data-bs-toggle="modal" data-bs-target="#modalEnviarDiscrepancias">Notificar informações incorretas</button>
            <button @click="irParaTermos" class='botaoBooat botaoLogin col-3 me-4 rounded-2'>Continuar para os termos</button>

        </div>
    </div>

<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="module" type="text/javascript" src="{{ asset('js/leituraContrato.js') }}"></script>

@component('components.modal.modal')
    @slot('id_modal', 'modalEnviarDiscrepancias')
    @slot('titulo_modal', 'Notifique o que está errado')
    @slot('corpo_modal')

        @csrf

        <div class="col-12">
            <input type="hidden" name="controleContrato" id="controleContrato" value="{{ session('contrato_para_assinar.controleContrato') }}">

            <div class="d-flex flex-column">
                <label class="d-flex justify-content-start">Insira seu e-mail abaixo</label>
                <input class="form-control form-control-md" type="text" placeholder="email@email.com.br" name="emailContratante" id="emailContratante">
            </div>

            <div class="d-flex flex-column">
                <label class="d-flex justify-content-start">Informe o CPF ou CNPJ da empresa contratante</label>
                <input @keypress="mascaraCPF_CNPJ" class="form-control form-control-md" type="text" placeholder="XXX.XXX.XXX-XX" name="cpfCnpjContratante" id="cpfCnpjContratante">
            </div>

            <div class="d-flex flex-column">
                <label class="d-flex justify-content-start">Descreva abaixo a(s) discrepância(s) em seu contrato</label>
                <textarea class="form-control form-control-md" type="text" placeholder="" rows="4" name="discrepancias" id="discrepancias"></textarea>
            </div>
        </div>

    @endslot
    @slot('botoes_modal')
        <button id="bt-fechar-modal-discrepancias" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button @click="enviarInformacoes" type="button" class="btn btn-primary">Salvar mudanças</button>
    @endslot
@endcomponent

    @component('components.modal.modal')
        @slot('id_modal', 'modalEnviando')
        @slot('titulo_modal', 'Envio de discrepâncias')
        @slot('corpo_modal')

            Enviando...

        @endslot
        @slot('botoes_modal', '')
    @endcomponent


    @component('components.modal.modal')
    @slot('id_modal', 'modalStatusEnvioDiscrepancias')
    @slot('titulo_modal', 'Envio de discrepâncias')
    @slot('corpo_modal')

        @{{ mensagem }}

    @endslot
    @slot('botoes_modal')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
    @endslot
@endcomponent

@endsection
