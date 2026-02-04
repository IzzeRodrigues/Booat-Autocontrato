import HOME from "./root.js";

let vmPagamentoCartao = new Vue({
    el: '#vmPagamentoCartao',

    data: {},

    methods: {

        mascaraCPF_CNPJ(){
            let numero = document.querySelector('#numDocumento').value;
            if(numero.length < 14){
                $('#numDocumento').mask('000.000.000-00');
            } else {
                $('#numDocumento').mask('00.000.000/0000-00');
            }
        },

        async pagar()
        {

            let modalRealizando = new bootstrap.Modal(document.getElementById('ModalRealizandoPagamento'), {
                keyboard: false
            })
            modalRealizando.show();

            let chave_publica = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2SxzOJnj4YuzaXuNuAkgJCkz3fdp4CTLxI0T3fQFhTQZhDYqujZOXQsID10bWROgEBjODuAB5SqEkfuzsfQfmmibb94U29Ki1845wPJtdRkK01jJU6zdQJzkoa0B2pIXsM34Dqot1aEHtvF5uAx3jsgA/2ihJAEu0ijqpo/sLZWImpQaKPrvB8ZHLTscM7mcPMzSWSv3XK9iUVvTtRbpXZGBT8OsGSEBCa7YJVkrm8E7au7jzhhZzeYQhuMm64dR21Ri1jpwTEZaaehGx/h5c40Ht/QG6ucf4XGZW3Sj6eogP6CNgMepfNRgbOFM/RDuxAzYQD/XRU2zVAYJOCzP8wIDAQAB';

            const card = PagSeguro.encryptCard({
                publicKey: chave_publica,
                holder:  document.querySelector('#nomeCartao').value,
                number:  document.querySelector('#numCartao').value,
                expMonth:  document.querySelector('#mes').value,
                expYear:  document.querySelector('#ano').value,
                securityCode:  document.querySelector('#cvv').value,
            });

            const encrypted = card.encryptedCard;
            const hasErrors = card.hasErrors;
            const errors = card.errors;

            console.log('encriptamento: '+ encrypted, 'se tem erros: '+hasErrors, 'lista de erros:' + errors);

            if(!hasErrors){
                let dados = new FormData();
                dados.append('_token', document.querySelector('input[name=_token]').value);
                dados.append('encrypted', encrypted);
                dados.append('security_code', document.querySelector('#cvv').value);
                dados.append('holder', document.querySelector('#nomeCartao').value);

                dados.append('controleContrato', document.querySelector('#controleContrato').value);
                dados.append('nomeComprador', document.querySelector('#nomeComprador').value);
                dados.append('nomeEstabelecimento', document.querySelector('#nomeEstabelecimento').value);
                dados.append('numDocumento', document.querySelector('#numDocumento').value);
                dados.append('endEmail', document.querySelector('#endEmail').value);

                let response = await fetch(
                    `${HOME()}/pagar-com-cartao`,{
                        method: 'post',
                        body: dados
                    }
                )

                let data = await response.json();

                if(data.status === 'ok'){
                    modalRealizando.hide();
                    location.href = '/conclusaoPagamento';
                }
            }

        }

    },

    mounted(){},
});
