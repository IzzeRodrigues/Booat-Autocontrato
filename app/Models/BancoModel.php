<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\support\facades\DB;

class BancoModel extends Model
{
    use HasFactory;

    function create(Request $request)
    {
        $nomeContrato = "Contrato Booat-". $request->nomeContratante;
        $token = random_int(100000, 999999);
        $controleContrato = random_int(100000, 999999);
        $controleContratante = random_int(100000, 999999);
        $status = "A pagar";

        $diaContrato = $request->diaContrato;
        $mesContrato = $request->mesContrato;
        $anoContrato = $request->anoContrato;
        $dataContrato = "$anoContrato-$mesContrato-$diaContrato";

        DB::insert('insert into tb_contrato (nm_contrato, vl_contrato, ds_tipo_plano, nr_parcelas, nr_tempo_duracao, nr_tempo_midia, vl_rescisao, nr_tempo_rescisao, nr_tempo_validade, dt_contrato, nr_token, ds_status, cd_controle_contrato) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[$nomeContrato, $request->valor, $request->tipoPlano, $request->parcelas, $request->duracaoServico, $request->antecipacaoMidia, $request->valorRescisao, $request->tempoRescisao, $request->validadeContrato, $dataContrato, $token, $status, $controleContrato]);

        $codigoContrato = DB::select('select cd_contrato from tb_contrato where cd_controle_contrato = "' . $controleContrato . '"');

        $semiResultado = $codigoContrato[0];

        $resultado = $semiResultado->cd_contrato;

        DB::insert('insert into tb_contratante (nm_contratante, cd_cnpj_contratante, nm_email_contratante, ds_tipo_contratante, cd_controle_contratante, cd_contrato) values (?, ?, ?, ?, ?, ?)', [$request->nomeContratante, $request->cnpjContratante, $request->emailContratante, $request->tipoEstabelecimento, $controleContratante, $resultado]);

        $codigoContratante = DB::select('select cd_contratante from tb_contratante where cd_controle_contratante = "' . $controleContratante . '"');

        $semiResultado = $codigoContratante[0];

        $resultado = $semiResultado->cd_contratante;

        DB::insert('insert into tb_representante (nm_representante, cd_cpf_representante, cd_contratante) values (?, ?, ?)', [$request->nomeRepresentante, $request->cpfRepresentante, $resultado]);

        DB::insert('insert into tb_endereco_contratante (nm_endereco, nr_numero, nm_bairro, nm_cidade, sg_uf, cd_contratante) values (?, ?, ?, ?, ?, ?)', [$request->enderecoContratante, $request->numeroContratante, $request->bairroContratante, $request->cidadeContratante, $request->uf, $resultado]);

        $link = "http://localhost:8000/assinarContrato?controleContrato=$controleContrato";

        return redirect()->route('enviarEmail', ['link' => $link, 'token' => $token, 'emailContratante' => $request->emailContratante, 'nome' => $request->nomeRepresentante, 'nomeContrato' => $nomeContrato]);
        
    }

    function index(Request $request)
    {
        $controleContrato = $_REQUEST['controleContrato'];

        $solicitacao = DB::select("select * from tb_contrato where cd_controle_contrato = $controleContrato");

        $contrato = $solicitacao[0];
        
        $solicitacao = DB::select("select * from tb_contratante where cd_contrato = $contrato->cd_contrato");
        
        $contratante = $solicitacao[0];
        
        $solicitacao = DB::select("select * from tb_representante where cd_contratante = $contratante->cd_contratante");
        
        $representante = $solicitacao[0];

        $solicitacao = DB::select("select * from tb_endereco_contratante where cd_contratante = $contratante->cd_contratante");

        $endereco = $solicitacao[0];

        $data = $contrato->dt_contrato;

        $data = explode('-', $data);

        $ano = $data[0];
        $mes = $data[1];
        $dia = $data[2];

        $dados= [
            'nomeContratante' => $contratante->nm_contratante,
            'enderecoContratante' => $endereco->nm_endereco,
            'numeroContratante' => $endereco->nr_numero,
            'bairroContratante' => $endereco->nm_bairro,
            'cidadeContratante' => $endereco->nm_cidade,
            'uf' => $endereco->sg_uf,
            'cnpjContratante' => $contratante->cd_cnpj_contratante,
            'nomeRepresentante' => $representante->nm_representante,
            'cpfRepresentante' => $representante->cd_cpf_representante,
            'valor' => $contrato->vl_contrato,
            'parcelas' => $contrato->nr_parcelas,
            'duracaoServico' => $contrato->nr_tempo_duracao,
            'antecipacaoMidia' => $contrato->nr_tempo_midia,
            'tipoPlano' => $contrato->ds_tipo_plano,
            'tipoEstabelecimento' => $contratante->ds_tipo_estabelecimento,
            'valorRescisao' => $contrato->vl_rescisao,
            'tempoRescisao' => $contrato->nr_tempo_rescisao,
            'emailContratada' => "booat.ads@booat.com.br",
            'emailContratante' => $contratante->nm_email_contratante,
            'validadeContrato' => $contrato->nr_tempo_validade,
            'diaContrato' => $dia,
            'mesContrato' => $mes,
            'anoContrato' => $ano,
            'controleContrato' => $contrato->cd_controle_contrato,
            'tokenBanco' => $contrato->nr_token,
        ];

        return redirect()->action('App\Http\Controllers\ContratoController@leitura' , $dados);
    }

    function verificarToken(Request $request)
    {
        $controleContrato = $request->controleContrato;

        $semiresultado = DB::select("select nr_token, cd_contrato from tb_contrato where cd_controle_contrato = $controleContrato");

        $resultado = $semiresultado[0];

        $tokenBanco = $resultado->nr_token;

        $tokenAssinatura = $request->tokenAssinatura;

        date_default_timezone_set('America/Sao_Paulo');
        $data = time();
        $dia = "d";
        $mes = "m";
        $ano = "Y";
        $hora = "H:i:s"; 

        $diaAssinatura = date($dia, $data);
        $mesAssinatura = date($mes, $data);
        $anoAssinatura = date($ano, $data);
        $horaAssinatura = date($hora, $data);

        $dataAssinatura = "$anoAssinatura-$mesAssinatura-$diaAssinatura $horaAssinatura";

        if ($tokenAssinatura == $tokenBanco)
        {
            DB::insert("insert into tb_assinatura (nm_pessoa, cd_cpf_pessoa, dt_assinatura, cd_contrato) values (?, ?, ?, ?)",[$request->nomeAssinatura, $request->cpfAssinatura, $dataAssinatura, $resultado->cd_contrato]);
            return redirect()->route('pagamento', ['contrato' => $resultado->cd_contrato]);
        }
        else
        {
            return redirect()->route('termos', ['erro' => 'Token inválido', 'controleContrato' => $controleContrato]);
        }
    }

    public function verificarUsuario(Request $request)
    {
        $usuario = $request->usuario;
        $senha = $request->senha;

        echo($usuario);

        $resultado = DB::select("select * from tb_usuario where nm_usuario = '$usuario'");

        if(!isset($resultado[0]))
        {
            $resultado = DB::select("select * from tb_usuario where nm_email_usuario = '$usuario'");
        }

        if(!isset($resultado[0]))
        {
            return redirect()->route('inicio', ['erro' => 'Usuário não existente']);
        }

        $resultado = $resultado[0];

        if ($senha != $resultado->nm_senha_usuario)
        {
            return redirect()->route('inicio', ['erro' => 'Senha incorreta']);
        }

        return redirect()->route('criarContrato');

    }

    public function solicitarContrato(Request $request)
    {
        $semiresultado = DB::select("select * from tb_contrato where cd_contrato = '$request->contrato'");

        $contrato = $semiresultado[0];

        $dados= [
            'valor' => $contrato->vl_contrato,
            'parcelas' => $contrato->nr_parcelas,
            'nomeContrato' => $contrato->nm_contrato,
            'duracaoServico' => $contrato->nr_tempo_duracao,
            'antecipacaoMidia' => $contrato->nr_tempo_midia,
            'tipoPlano' => $contrato->ds_tipo_plano,
            'valorRescisao' => $contrato->vl_rescisao,
            'tempoRescisao' => $contrato->nr_tempo_rescisao,
            'emailContratada' => "booat.ads@booat.com.br",
            'validadeContrato' => $contrato->nr_tempo_validade,
            'controleContrato' => $contrato->cd_controle_contrato,
            'contrato' => $request->contrato,
            'comprador' => $request->comprador,
            'email' => $request->email,
            'documento' => $request->documento,
            'encriptacao' => $request->encriptacao,
            'nomeCartao' => $request->nomeCartao,
            'cvv' => $request->cvv
        ];

        return redirect()->route('pedido', $dados);
    }

    public function salvarPagamento(Request $request)
    {
        $data = $request->data;
        $mensagem = $request->mensagem;
        $status = $request-> status;
        $contrato = $request->contrato;
        $comprador = $request->comprador;
        $documento = $request->documento;

        DB::insert("insert into tb_pagamento (nm_pagante, cd_cpf_pagante, dt_pagamento, cd_contrato) values (?, ?, ?, ?)", [$comprador, $documento, $data, $contrato]);

        $semiresultado = DB::select("select * from tb_contrato where cd_contrato = '$contrato'");

        $dadosContrato = $semiresultado[0];

        DB::update("update tb_contrato set ds_status = 'Pago' where cd_contrato = '$contrato'");

        return redirect()->route('dadosContratoAssinado', ['contrato' => $contrato]);
    }

    public function dadosContratoAssinado(Request $request)
    {
        $semiresultado = DB::select("select * from tb_contrato where cd_contrato = '$request->contrato'");

        $contrato = $semiresultado[0];

        $semiresultado = DB::select("select * from tb_contratante where cd_contrato = '$request->contrato'");

        $contratante = $semiresultado[0];

        $semiresultado = DB::select("select * from tb_endereco_contratante where cd_contratante = '$contratante->cd_contratante'");

        $endereco = $semiresultado[0];

        $semiresultado = DB::select("select * from tb_representante where cd_contratante = '$contratante->cd_contratante'");

        $representante = $semiresultado[0];

        $semiresultado = DB::select("select * from tb_assinatura where cd_contrato = '$request->contrato'");

        $assinatura = $semiresultado[0];

        $dados = [
            'nomeContrato' => $contrato->nm_contrato,
            'valor' => $contrato->vl_contrato,
            'parcelas' => $contrato->nr_parcelas,
            'duracaoServico' => $contrato->nr_tempo_duracao,
            'antecipacaoMidia' => $contrato->nr_tempo_midia,
            'tipoPlano' => $contrato->ds_tipo_plano,
            'tipoEstabelecimento' => $contratante->ds_tipo_estabelecimento,
            'valorRescisao' => $contrato->vl_rescisao,
            'tempoRescisao' => $contrato->nr_tempo_rescisao,
            'dataContrato' => $contrato->dt_contrato,
            'tempoValidade' => $contrato->nr_tempo_validade,
            'nomeContratante' => $contratante->nm_contratante,
            'cnpjContratante' => $contratante->cd_cnpj_contratante,
            'emailContratante' => $contratante->nm_email_contratante,
            'enderecoContratante' => $endereco->nm_endereco,
            'numeroContratante' => $endereco->nr_numero,
            'bairroContratante' => $endereco->nm_bairro,
            'cidadeContratante' => $endereco->nm_cidade,
            'uf' => $endereco->sg_uf,
            'nomeRepresentante' => $representante->nm_representante,
            'cpfRepresentante' => $representante->cd_cpf_representante,
            'nomeAssinatura' => $assinatura->nm_pessoa,
            'cpfAssinatura' => $assinatura->cd_cpf_pessoa,
            'dataAssinatura' => $assinatura->dt_assinatura,
            'emailContratada' => "booat.ads@booat.com.br",
        ];

        return redirect()->action('App\Http\Controllers\ContratoController@contratoAssinado', $dados);

    }

}
