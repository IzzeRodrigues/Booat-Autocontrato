import validaCpfCnpj from "./ValidarCPF_CNPJ.js";

let vmCriarContrato = new Vue({
    el: '#vmCriarContrato',

    data: {
        mensagem_erro: '',
    },

    methods: {

        somenteNumeros(event) {
            console.log(event.keyCode);
            let charCode = event.keyCode;
            // charCode 8 = backspace
            // charCode 9 = tab
            if (charCode !== 8 && charCode !== 9) {
                // charCode 48 equivale a 0
                // charCode 57 equivale a 9
                if (charCode < 48 || charCode > 57) {
                    event.preventDefault();
                    return false;
                }
            }
        },

        mascaras()
        {
            $('#cnpjContratante').mask('00.000.000/0000-00', {clearIfNotMatch: true});
            $('#cpf').mask('000.000.000-00', {clearIfNotMatch: true});
            $('#cep').mask('00.000-000', {clearIfNotMatch: true});
            $('#valor').maskMoney({ prefix: '', thousands: ".", decimal: ",", precision: 2, });
            $('#valorRescisao').maskMoney({ suffix: '', thousands: ".", decimal: ",", precision: 2, });
        },

        verificarCampos(event){

            let documentos = true;
            let continuar = true;

            if(validaCpfCnpj(document.querySelector('#cpf').value) === false){
                documentos = false;
                continuar = false;
                event.preventDefault();
                vmMensagemErro.mostrar('O CPF do Representante informado é inválido. Verifique e tente novamente.');
                return;
            }

            if(validaCpfCnpj(document.querySelector('#cnpjContratante').value) === false){
                documentos = false;
                continuar = false;
                event.preventDefault();
                vmMensagemErro.mostrar('O CNPJ do Contratante informado é inválido. Verifique e tente novamente.');
                return;
            }

            let campos = [
                'nomeContratante',
                'cnpjContratante',
                'tipoEstabelecimento',
                'nomeRepresentante',
                'cpf',
                'antecipacaoMidia',
                'endereco',
                'numeroContratante',
                'bairro',
                'cidade',
                'uf',
                'cep',
                'emailContratante',
                'tempoRescisao',
                'valorRescisao',
                'tipoPlano',
                'validadeContrato',
                'valor',
                'parcelas',
                ];

            for(let i = 0; i < campos.length; i++){
                if(document.querySelector(`#${campos[i]}`).value === ''){
                    continuar = false;
                }
            }

            if(!continuar){
                if(documentos === true){
                    let modalCamposObrigatorios = new bootstrap.Modal(document.getElementById('ModalCamposObrigatorios'), {
                        keyboard: false
                    })
                    modalCamposObrigatorios.show();
                }
                event.preventDefault();
            }
        },

    },

    mounted(){
        this.mascaras();
    },
});


let vmMensagemErro = new Vue({
    el: '#ErroModal',

    data: {
        mensagem_erro: '',
    },

    methods: {
        mostrar(mensagem){
            this.mensagem_erro = mensagem;
            let ErroModal = new bootstrap.Modal(document.getElementById('ErroModal'), {
                keyboard: false
            })
            ErroModal.show();
        }
    },
});
