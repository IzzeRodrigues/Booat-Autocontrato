import validaCpfCnpj from "./ValidarCPF_CNPJ.js";

let vmTermos = new Vue({
    el: '#vmTermos',

    data: {
        mostrar_checkbox: false,
    },

    methods: {

        verificarErroToken()
        {
            const url = window.location.search;
            const params = new URLSearchParams(url);
            console.log(params);
            if(params.get('erro') === 'token'){
                let modal = new bootstrap.Modal(document.getElementById('modalTokenInvalido'), {
                    keyboard: false
                });

                modal.show();
            }
        },

        verificarCampos(event)
        {

            let continuar = true;
            let documento = true;

            if(validaCpfCnpj(document.querySelector('#cpfAssinatura').value) === false){
                documento = false;
                event.preventDefault();
                vmMensagemErro.mostrar('O CPF informado é inválido.');
                return;
            }

            let campos = [
                'nomeAssinatura',
                'cpfAssinatura',
                'tokenAssinatura',
            ];

            for(let i = 0; i < campos.length; i++){
                if(document.querySelector(`#${campos[i]}`).value === ''){
                    continuar = false;
                }
            }

            if (!continuar){
                event.preventDefault();
                vmMensagemErro.mostrar('Todos os campos são obrigatórios');
                return;
            }

            let sercet = '6LcDRFMoAAAAAOt88om-wkaLJrogQ8Tuhv6vm8G0';

            let response = grecaptcha.getResponse();

            if(response === '' || response === undefined || response === null){
                event.preventDefault();
                vmMensagemErro.mostrar('Selecione o captcha.');
                return;
            }

        }

    },

    mounted(){
        function mostrarCheckbox(){
            this.mostrar_checkbox = true;
        }

        window.addEventListener('DOMContentLoaded', () => {

            $('#termos').bind('scroll', function() {
                /*
                * scrollTop -> Quanto rolou
                * innerHeight -> Altura do interior da div
                * scrollHeight -> Altura do conteúdo da div
                */
                if($(this).scrollTop() + $(this).innerHeight() >= (this.scrollHeight-1)) {
                    document.querySelector('#box-checkbox').classList.remove('oculto');
                }
            });

            $('#cpfAssinatura').mask('000.000.000-00', {clearIfNotMatch: true});
            this.verificarErroToken();
        });

    }
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
