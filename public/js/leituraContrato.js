import HOME from "./root.js";
import validaCpfCnpj from "./ValidarCPF_CNPJ.js";

let vmLeituraContrato = new Vue({
    el: '#vmLeituraContrato',

    data: {},

    methods: {
        irParaTermos(){
            location.href = '/termos'
        },
    },

    mounted(){},
});

let vmModalEnviarDiscrepancias = new Vue({
    el: '#modalEnviarDiscrepancias',

    data: {
        mensagem: '',
    },

    methods: {

        mascaraCPF_CNPJ(){
            let numero = document.querySelector('#cpfCnpjContratante').value;
            if(numero.length < 14){
                $('#cpfCnpjContratante').mask('000.000.000-000');
            } else {
                $('#cpfCnpjContratante').mask('00.000.000/0000-00');
            }
        },

        verificarCampos()
        {
            let continuar = true;
            let documento = true;

            if(validaCpfCnpj(document.querySelector('#cpfCnpjContratante').value) === false){
                continuar = false;
                documento = false;
                vmModalStatusEnvioDiscrepancias.mostrar('Número do CPF/CNPJ inválido.');
                return false;
            }

            let campos = [
                'emailContratante',
                'cpfCnpjContratante',
                'discrepancias',
            ];

            for(let i = 0; i < campos.length; i++){
                if(document.querySelector(`#${campos[i]}`).value === ''){
                    continuar = false;
                }
            }

            if(!continuar){
                vmModalStatusEnvioDiscrepancias.mostrar('Todos os campos são obrigatórios.');
                return false;
            }

            return true;
        },

        async enviarInformacoes(){
            if(!this.verificarCampos()){
                return;
            }

            let ModalEnviando = new bootstrap.Modal(document.getElementById('modalEnviando'), {
                keyboard: false
            });

            ModalEnviando.show();

            let dados = new FormData();
            dados.append('_token', document.querySelector('input[name=_token]').value);
            dados.append('controleContrato', document.querySelector('#controleContrato').value);
            dados.append('emailContratante', document.querySelector('#emailContratante').value);
            dados.append('cpfCnpjContratante', document.querySelector('#cpfCnpjContratante').value);
            dados.append('discrepancias', document.querySelector('#discrepancias').value);

            let response = await fetch(
                `${HOME()}/enviar-discrepancias`, {
                    method: 'post',
                    body: dados
                }
            );

            let data = await response.json();

            if(data.status === 'ok'){
                ModalEnviando.hide();
                document.querySelector('#bt-fechar-modal-discrepancias').click();
                vmModalStatusEnvioDiscrepancias.mostrar('Discrepâncias enviadas com sucesso.');
            } else {
                ModalEnviando.hide();
                document.querySelector('#bt-fechar-modal-discrepancias').click();
                vmModalStatusEnvioDiscrepancias.mostrar('Ops! Algo saiu errado. Por favor tente novamente');
            }
        },
    },

    mounted(){
        this.mascaraCPF_CNPJ();
    },
});

let vmModalStatusEnvioDiscrepancias = new Vue({
    el: '#modalStatusEnvioDiscrepancias',

    data: {
        mensagem: '',
    },

    methods: {
        mostrar(mensagem){
            this.mensagem = mensagem;
            let ErroModal = new bootstrap.Modal(document.getElementById('modalStatusEnvioDiscrepancias'), {
                keyboard: false
            })
            ErroModal.show();
        }
    }
});
