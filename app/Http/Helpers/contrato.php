<?php
if(!function_exists('contratoTemporario')){
    function contratoTemporario($request)
    {
        $dados_contrato['contrato_temporario'] = [
            'nomeContratante' => $request->nomeContratante,
            'enderecoContratante' => $request->enderecoContratante,
            'numeroContratante' => $request->numeroContratante,
            'bairroContratante' => $request->bairroContratante,
            'cidadeContratante' => $request->cidadeContratante,
            'uf' => $request->uf,
            'cep' => $request->cep,
            'cnpjContratante' => $request->cnpjContratante,
            'nomeRepresentante' => $request->nomeRepresentante,
            'cpfRepresentante' => $request->cpfRepresentante,
            'valor' => $request->valor,
            'parcelas' => $request->parcelas,
            'duracaoServico' => $request->duracaoServico,
            'antecipacaoMidia' => $request->antecipacaoMidia,
            'tipoPlano' => $request->tipoPlano,
            'valorRescisao' => $request->valorRescisao,
            'tempoRescisao' => $request->tempoRescisao,
            'emailContratada' => $request->emailContratada,
            'emailContratante' => $request->emailContratante,
            'validadeContrato' => $request->validadeContrato,
            'tipoEstabelecimento' => $request->tipoEstabelecimento,
        ];

        session($dados_contrato);
    }
}

if(!function_exists('arquivoContratoTemporario')){
    function arquivoContratoTemporario(string $nome_arquivo){
        $dados_contrato['arquivo_contrato_temporario']['filename'] = $nome_arquivo;
        session($dados_contrato);
    }
}

if(!function_exists('limparContratoTemporario')){
    function limparContratoTemporario()
    {
        session()->forget('contrato_temporario');
        session()->forget('arquivo_contrato_temporario');
    }
}

if(!function_exists('contratoParaAssinar')){
    function contratoParaAssinar($contrato, $contratante, $representante, $endereco, $dia, $mes, $ano){
        $dados_contrato['contrato_para_assinar'] = [
            'filename' => $contrato[0]->arquivo,
            'cd_contrato' => $contrato[0]->cd_contrato,
            'nomeContratante' => $contratante[0]->nm_contratante,
            'enderecoContratante' => $endereco[0]->nm_endereco,
            'numeroContratante' => $endereco[0]->nr_numero,
            'bairroContratante' => $endereco[0]->nm_bairro,
            'cidadeContratante' => $endereco[0]->nm_cidade,
            'uf' => $endereco[0]->sg_uf,
            'cnpjContratante' => $contratante[0]->cd_cnpj_contratante,
            'nomeRepresentante' => $representante[0]->nm_representante,
            'cpfRepresentante' => $representante[0]->cd_cpf_representante,
            'valor' => $contrato[0]->vl_contrato,
            'parcelas' => $contrato[0]->nr_parcelas,
            'duracaoServico' => $contrato[0]->nr_tempo_duracao,
            'antecipacaoMidia' => $contrato[0]->nr_tempo_midia,
            'tipoPlano' => $contrato[0]->ds_tipo_plano,
            'tipoEstabelecimento' => $contratante[0]->ds_tipo_estabelecimento,
            'valorRescisao' => $contrato[0]->vl_rescisao,
            'tempoRescisao' => $contrato[0]->nr_tempo_rescisao,
            'emailContratada' => "booat.ads@booat.com.br",
            'emailContratante' => $contratante[0]->nm_email_contratante,
            'validadeContrato' => $contrato[0]->nr_tempo_validade,
            'diaContrato' => $dia,
            'mesContrato' => $mes,
            'anoContrato' => $ano,
            'controleContrato' => $contrato[0]->cd_controle_contrato,
            'tokenBanco' => $contrato[0]->nr_token,
        ];

        session($dados_contrato);
    }
}

if(!function_exists('limparContratoParaAssinar')){
    function limparContratoParaAssinar()
    {
        session()->forget('contrato_para_assinar');
    }
}
