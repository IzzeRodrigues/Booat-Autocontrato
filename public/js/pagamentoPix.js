import HOME from "./root.js";

let vmPagamentoPix = new Vue({
    el: '#vmPagamentoPix',

    data: {
        id_transacao: '',
        qr_code_image: '',
        qr_code_text: '',
    },

    methods: {

        async gerarQRCode()
        {

            let modalGerando = new bootstrap.Modal(document.getElementById('ModalGerandoQRCode'), {
                keyboard: false
            })
            modalGerando.show();

            let chave_publica = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2SxzOJnj4YuzaXuNuAkgJCkz3fdp4CTLxI0T3fQFhTQZhDYqujZOXQsID10bWROgEBjODuAB5SqEkfuzsfQfmmibb94U29Ki1845wPJtdRkK01jJU6zdQJzkoa0B2pIXsM34Dqot1aEHtvF5uAx3jsgA/2ihJAEu0ijqpo/sLZWImpQaKPrvB8ZHLTscM7mcPMzSWSv3XK9iUVvTtRbpXZGBT8OsGSEBCa7YJVkrm8E7au7jzhhZzeYQhuMm64dR21Ri1jpwTEZaaehGx/h5c40Ht/QG6ucf4XGZW3Sj6eogP6CNgMepfNRgbOFM/RDuxAzYQD/XRU2zVAYJOCzP8wIDAQAB';

            let dados = new FormData();
            dados.append('_token', document.querySelector('input[name=_token]').value);

            dados.append('controleContrato', document.querySelector('#controleContrato').value);
            dados.append('nomeComprador', document.querySelector('#nomeComprador').value);
            dados.append('nomeEstabelecimento', document.querySelector('#nomeEstabelecimento').value);
            dados.append('numDocumento', document.querySelector('#numDocumento').value);
            dados.append('endEmail', document.querySelector('#endEmail').value);

            let response = await fetch(
                `${HOME()}/gerar-qr-code`,{
                    method: 'post',
                    body: dados
                }
            )

            let data = await response.json();

            if(data.status === 'ok'){
                this.id_transacao = data.id_transacao;
                this.qr_code_image = data.qr_code_image;
                this.qr_code_text = data.qr_code_text;
                modalGerando.hide();

                await this.consultarPagamento();
            }

        },

        async consultarPagamento(){

            setInterval(async () => {
                let response = await fetch(
                    `${HOME()}/verificarPagamento/${this.id_transacao}`,{
                        method: 'get'
                    }
                );

                let data = await response.json();

                if(data.status === 'ok'){
                    location.href = '/conclusaoPagamento';
                }
            }, 30000);

        },

    },

    mounted(){},
});
