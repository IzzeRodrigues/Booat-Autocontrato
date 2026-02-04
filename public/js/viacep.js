function pesquisarCep(cep)
{
    var cep = cep.replace(/\D/g, '');

    if(cep != "")
    {
        var validacaoCep = /^[0-9]{8}$/;

        if(validacaoCep.test(cep))
        {
            document.getElementById('endereco').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('uf').value="AC";
            
            var script = document.createElement('script');
            
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=retorno';
            
            document.body.appendChild(script);
            
        }
        else
        {
            document.getElementById('endereco').value="";
            document.getElementById('bairro').value="";
            document.getElementById('cidade').value="";
            document.getElementById('uf').value="AC";
        }
    }
    else
    {
        document.getElementById('endereco').value="";
        document.getElementById('bairro').value="";
        document.getElementById('cidade').value="";
        document.getElementById('uf').value="AC";
    }
};

function retorno(resposta)
{
    if (resposta.logradouro == 'undefined' || resposta.bairro == 'undefined' || resposta.localidade == 'undefined' || resposta.uf == undefined)
    {
        document.getElementById('endereco').value="";
        document.getElementById('bairro').value="";
        document.getElementById('cidade').value="";
        document.getElementById('uf').value="AC";
    }
    else
    {
        document.getElementById('endereco').value=(resposta.logradouro);
        document.getElementById('bairro').value=(resposta.bairro);
        document.getElementById('cidade').value=(resposta.localidade);
        document.getElementById('uf').value=(resposta.uf);
    }
    
}