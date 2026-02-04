  let parametros = new URLSearchParams(window.location.search);

  const chave = parametros.get("chave")
  const comprador = parametros.get("comprador");
  const companhia = parametros.get("companhia");
  const documento = parametros.get("documento");
  const email = parametros.get("email");
  const nomeCartao = parametros.get("nomeCartao");
  const numCartao = parametros.get("numCartao");
  const cvv = parametros.get("cvv");
  const mes = parametros.get("mes");
  const ano = parametros.get("ano");
  const parcelas = parametros.get("parcelas");
  const contrato = parametros.get("contrato");

  const card = PagSeguro.encryptCard({
    publicKey: chave,
    holder: nomeCartao,
    number: numCartao,
    expMonth: mes,
    expYear: ano,
    securityCode: cvv
  });
  
  const encrypted = card.encryptedCard;
  const hasErrors = card.hasErrors;
  const errors = card.errors;
  const encriptado = encrypted.replaceAll('+', '%2B');

  window.location.href= `http://localhost:8000/solicitarInformacoesContrato?encriptacao=${encriptado}&comprador=${comprador}&companhia=${companhia}&documento=${documento}&email=${email}&nomeCartao=${nomeCartao}&cvv=${cvv}&parcelas=${parcelas}&contrato=${contrato}`