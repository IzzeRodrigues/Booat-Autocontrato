<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\Contratante;
use App\Models\Contrato;
use App\Models\EnderecoContratante;
use App\Models\Representante;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use SendGrid\Mail\Mail;

class ContratoController extends Controller
{
    public function index(Request $request)
    {

        /*
        $nomeContratante = $_REQUEST['nomeContratante'];
        $enderecoContratante = $_REQUEST['enderecoContratante'];
        $numeroContratante = $_REQUEST['numeroContratante'];
        $bairroContratante = $_REQUEST['bairroContratante'];
        $cidadeContratante = $_REQUEST['cidadeContratante'];
        $uf = $_REQUEST['uf'];
        $cnpjContratante = $_REQUEST['cnpjContratante'];
        $nomeRepresentante = $_REQUEST['nomeRepresentante'];
        $cpfRepresentante = $_REQUEST['cpfRepresentante'];
        $valor = $_REQUEST['valor'];
        $parcelas = $_REQUEST['parcelas'];
        $duracaoServico = $_REQUEST['duracaoServico'];
        $antecipacaoMidia = $_REQUEST['antecipacaoMidia'];
        $tipoPlano = $_REQUEST['tipoPlano'];
        $valorRescisao = $_REQUEST['valorRescisao'];
        $tempoRescisao = $_REQUEST['tempoRescisao'];
        $emailContratada = 'booat@booat.com.br';
        $emailContratante = $_REQUEST['emailContratante'];
        $validadeContrato = $_REQUEST['validadeContrato'];
        $tipoEstabelecimento = $_REQUEST['tipoEstabelecimento'];
        */

        contratoTemporario($request);

        date_default_timezone_set('America/Sao_Paulo');
        $dataContrato = time();
        $dia = "d";
        $mes = "m";
        $ano = "Y";

        $diaContrato = date($dia, $dataContrato);
        $mesContrato = date($mes, $dataContrato);
        $anoContrato = date($ano, $dataContrato);
        $mesMostrado = '';

        switch($mesContrato)
        {
            case 1:
                $mesMostrado = "Janeiro";
                break;
            case 2:
                $mesMostrado = "Fevereiro";
                break;
            case 3:
                $mesMostrado = "Março";
                break;
            case 4:
                $mesMostrado = "Abril";
                break;
            case 5:
                $mesMostrado = "Maio";
                break;
            case 6:
                $mesMostrado = "Junho";
                break;
            case 7:
                $mesMostrado = "Julho";
                break;
            case 8:
                $mesMostrado = "Agosto";
                break;
            case 9:
                $mesMostrado = "Setembro";
                break;
            case 10:
                $mesMostrado = "Outubro";
                break;
            case 11:
                $mesMostrado = "Novembro";
                break;
            case 12:
                $mesMostrado = "Dezembro";
                break;
        }

        $guid_contrato = Uuid::uuid1();
        $filename = "{$guid_contrato->toString()}-contrato.pdf";
        arquivoContratoTemporario($filename);

        $data = [
            'title' => 'Gerando um contrato'
        ];

        $html = '<span style="text-align:justify;"><b>CONTRATANTE: </b>'. session('contrato_temporario.nomeContratante') . ', com sede no endereço '. session('contrato_temporario.enderecoContratante') . ', '.session('contrato_temporario.numeroContratante').' inscrito sob o CNPJ ' . session('contrato_temporario.cnpjContratante').' Representado por ' . session('contrato_temporario.nomeRepresentante') . ', portador do documento de número ' . session('contrato_temporario.cpfRepresentante') . '.<br>' .
        '<b>CONTRATADA:</b> BOOAT TECNOLOGIA LTDA, com sede na RUA GUAIAÓ, 66, APARECIDA, SANTOS/SP - CEP 11035-260, inscrita sob o CNPJ 24.661.945/0001-12.<br>' .
        '<br>As partes identificadas acima têm, entre si, justo e acertado o presente contrato de divulgação para o setor de ramo '. session('contrato_temporario.tipoEstabelecimento') .', que se regerá pelas cláusulas seguintes, condições de preço, forma e termo de pagamento descritas no presente documento. <br>' .
        '<br><b>Cláusula Primeira – Do Objeto</b><br><b>Parágrafo Primeiro.</b> O presente Contrato tem como objeto a reserva e direito das informações empresariais da CONTRATANTE, na plataforma de tecnologia disponibilizada pela CONTRATADA, denominado “mapa”, no prazo estipulado neste instrumento. As informações serão divulgadas no “ponto exato” do endereço da CONTRATANTE, garantindo uso exclusivo do espaço na plataforma sem a possibilidade qualquer outro sobrepor.
        <br><b>Parágrafo Segundo.</b> É responsabilidade da CONTRATANTE a disponibilização de todo material digital incluindo: logotipo da empresa em alta qualidade, fotos e quaisquer outros arquivos solicitados pela CONTRATADA. O material deverá obedecer às especificações da plataforma.<br>' .
        '<br><b>Cláusula Segunda – Do Pagamento</b><br><b>Parágrafo Único.</b> O valor acordado será de R$ ' .session('contrato_temporario.valor').' e deverá ser pago em '. session('contrato_temporario.parcelas') .' parcela(s) até a data de vencimento, através do link de pagamento enviado pela CONTRATADA.<br>' .
        '<br><b>Cláusula Terceira – Das Obrigações da Contratada</b><br><b>Parágrafo Primeiro.</b> A CONTRATADA se responsabiliza pelo desenvolvimento e publicação do estabelecimento em mapa no prazo máximo de <b>7 dias úteis</b> após a assinatura deste Contrato.
        <br><b>Parágrafo Segundo.</b> A CONTRATADA compromete-se a manter na plataforma, as informações comerciais da CONTRATANTE no prazo ajustado de ' . session('contrato_temporario.duracaoServico') . ' meses no formato “Ponto, Banner, Janela, Lista”.
        <b>Parágrafo Terceiro.</b> A CONTRATADA compromete-se a manter o software e informações do CONTRATANTE nos servidores do BOOAT pelo prazo ajustado de ' . session('contrato_temporario.duracaoServico') . ' meses a partir da assinatura deste contrato.<br>' .
        '<br><b>Cláusula Quarta – Das Obrigações da Contratante</b><br><b>Parágrafo Primeiro.</b> A CONTRATANTE compromete-se em realizar o pagamento do valor ajustado até a data de seu vencimento.
        <br><b>Parágrafo Segundo.</b> A CONTRATANTE compromete-se em enviar todo e qualquer material digital que corresponder a contratação do presente serviço nos termos do solicitado pela CONTRATADA com antecedência mínima de '. session('contrato_temporario.antecipacaoMidia') . ' dia(s) úteis.
        <br><b>Parágrafo Terceiro.</b> Caberá a CONTRATANTE informar à CONTRATADA sobre qualquer atualização de informações contidas em seu espaço publicado na plataforma, sempre que ocorrer qualquer alteração.
        <br><b>Parágrafo Quarto.</b> A CONTRATANTE se responsabiliza pelas informações comerciais contidas no seu espaço na plataforma, sendo essas disponibilizadas ao BOOAT no ato da contratação do seu plano '. session('contrato_temporario.tipoPlano') . ' e conferindo esta responsabilidade exclusivamente a CONTRATANTE.
        <br><b>Parágrafo Quinto.</b> A CONTRATANTE se responsabiliza a cumprir com as Políticas de Anúncios do BOOAT, e não veicular material de conteúdo proibido, sob pena de retirada do anúncio sem prejuízo de indenização em caso de perdas e danos pela CONTRATADA.
        <br><b>Parágrafo Sexto.</b> A CONTRATANTE garante que o uso do serviço não violará nenhuma lei aplicável ou direito de propriedade de terceiros.<br>' .
        '<br><br><b>Cláusula Quinta – Da Rescisão</b><br><b>Parágrafo Primeiro.</b> O presente instrumento poderá ser rescindido a qualquer momento por comum acordo entre as partes, dando-se por quitadas as obrigações.
        <br><b>Parágrafo Segundo.</b> O presente instrumento poderá ser rescindido unilateralmente caso qualquer uma das partes descumpra o disposto neste contrato, bem como, em caso de descumprimento de qualquer dos documentos que o acompanham.
        <br><b>Parágrafo Terceiro.</b> Caso o contrato seja rescindido pela CONTRATANTE, será obrigada a pagar à CONTRATADA os valores devidos de forma proporcional referentes aos serviços de desenvolvimento e divulgação que tenham sido prestados pela CONTRATADA até a data de rescisão deste contrato, conforme previsões contratuais definidas neste instrumento, bem como deverá pagar multa equivalente a '. session('contrato_temporario.valorRescisao') .'% do valor proporcional do contrato.
        <br><b>Parágrafo Quarto.</b> Caso a CONTRATADA dê motivo a rescisão do contrato, será obrigada a devolver a CONTRATANTE, os valores pagos de forma proporcional e correspondente aos serviços que não foram efetivamente prestados, conforme previsão contratual definidas no presente instrumento, no prazo de '. session('contrato_temporario.tempoRescisao') .' dias corridos da rescisão contratual.
        <br><b>Parágrafo Quinto.</b> Serão considerados válidos e eficazes os pedidos de desistência ou cancelamento dos serviços, enviados para o e-mail da CONTRATADA: '.session('contrato_temporario.emailContratada').' e/ou para o e-mail do(a) CONTRATANTE: '.session('contrato_temporario.emailContratante').' com confirmações de leitura, ou ainda, por meio dos correios com AR.<br>' .
        '<br><b>Cláusula Sexta – Das Disposições Gerais</b><br><b>Parágrafo Primeiro.</b> A CONTRATANTE concorda expressamente pleno acordo com todas as cláusulas presentes nesse contrato e declara entender e aceitar todas as condições estabelecidas nos princípios de publicidade, Política de Privacidade e Termo de Uso que consta anexo a este contrato antes de efetivar a contratação.
        <br><b>Parágrafo Segundo.</b> A CONTRATANTE se compromete a seguir o Manual do Anunciante e demais Políticas Internas estabelecidas pela CONTRATADA.
        <br><b>Parágrafo Terceiro.</b> Qualquer serviço solicitado pelo (a) CONTRATANTE que não esteja englobado no objeto do presente contrato, será realizado pela CONTRATADA mediante aprovação formal de orçamento complementar.
        <br><b>Parágrafo Quarto.</b> A partir da assinatura deste acordo, a CONTRATANTE autoriza expressamente a CONTRATADA o uso e reprodução da marca, imagem, foto, nome, logotipo e quaisquer outros arquivos inerentes à divulgação na plataforma, de forma irrestrita, a nível nacional, até o encerramento da vigência formal deste contrato.
        <br><b>Parágrafo Quinto.</b> A CONTRATANTE se compromete a atuar em consonância com a Lei Geral de Proteção de Dados (Lei 13.709/2018), garantindo a confidencialidade de quaisquer dados pessoais que possam vir a ser tratados em decorrência deste instrumento.<br>'.
        '<br><b>Cláusula Sétima – Do Prazo</b><br><b>Parágrafo Único.</b> Este Contrato terá validade de '.session('contrato_temporario.validadeContrato').' meses a partir da data de sua assinatura. <br>'.
        '<br><b>Cláusula Oitava – Da Forma</b><br><b>Parágrafo Único.</b> As partes declaram e concordam que o presente acordo, é firmado por meio digital e representa a integralidade dos termos entre elas acordados, substituindo quaisquer outros acordos anteriores formalizados por outro meio de comunicação, sendo mensagem, verbal ou digital nos termos dos arts. 107, 219 e 220 do Código Civil.<br>'.
        '<br><b>Cláusula Nona – Do Foro</b><br><b>Parágrafo Único.</b> Para dirimir quaisquer controvérsias oriundas do Contrato, as partes elegem o foro da comarca de Santos/SP, com exclusão de qualquer outro por mais privilegiado que seja.';;

        $pdf = new TCPDF;

        $pdf::SetTitle('Contratando');
        $pdf::AddPage();
        $pdf::writeHTML('<span style="text-align:center;"><b>CONTRATO DE DESENVOLVIMENTO E DIVULGAÇÃO</b><br>', true, false, true, false, "");
        $pdf::Ln(5);
        $pdf::writeHTML($html, true, false, true, false, "");
        $pdf::Write(10, "Santos, São Paulo - $diaContrato de $mesMostrado de $anoContrato.", '', 0, 'R');

        $tipo_conexao = $_SERVER['HTTP_HOST'];

        switch ($tipo_conexao):
            case 'localhost':
            case '127.0.0.1':
            case '127.0.0.1:8000':
                if(!file_exists(public_path('/contratos'))):
                    mkdir(public_path('/contratos'), 0777);
                endif;

                $pdf::Output(public_path('/contratos/').$filename, "F");
                break;

            case 'seagree.com.br':
                if(!file_exists(base_path().'/public_html/contratos')):
                    mkdir(base_path().'/public_html/contratos', 0777);
                endif;

                $pdf::Output(base_path().'/public_html/contratos/'.$filename, "F");
                break;
        endswitch;

        $dados= [
            'nomeContratante' => session('contrato_temporario.nomeContratante'),
            'enderecoContratante' => session('contrato_temporario.enderecoContratante'),
            'numeroContratante' => session('contrato_temporario.numeroContratante'),
            'bairroContratante' => session('contrato_temporario.bairroContratante'),
            'cidadeContratante' => session('contrato_temporario.cidadeContratante'),
            'tipoEstabelecimento' => session('contrato_temporario.tipoEstabelecimento'),
            'uf' => session('contrato_temporario.uf'),
            'cnpjContratante' => session('contrato_temporario.cnpjContratante'),
            'nomeRepresentante' => session('contrato_temporario.nomeRepresentante'),
            'cpfRepresentante' => session('contrato_temporario.cpfRepresentante'),
            'valor' => session('contrato_temporario.valor'),
            'parcelas' => session('contrato_temporario.parcelas'),
            'duracaoServico' => session('contrato_temporario.duracaoServico'),
            'antecipacaoMidia' => session('contrato_temporario.antecipacaoMidia'),
            'tipoPlano' => session('contrato_temporario.tipoPlano'),
            'valorRescisao' => session('contrato_temporario.valorRescisao'),
            'tempoRescisao' => session('contrato_temporario.tempoRescisao'),
            'emailContratada' => session('contrato_temporario.emailContratada'),
            'emailContratante' => session('contrato_temporario.emailContratante'),
            'validadeContrato' => session('contrato_temporario.validadeContrato'),
            'diaContrato' => $diaContrato,
            'mesContrato' => $mesContrato,
            'anoContrato' => $anoContrato,
            'pdf' => public_path($filename),
        ];

        return redirect()->route('confirmarContrato');
    }

    public function create(Request $request)
    {

        $nomeContrato = "Contrato Booat-".session('contrato_temporario.nomeContratante');
        $token = random_int(100000, 999999);
        $controleContrato = random_int(100000, 999999);
        $controleContratante = random_int(100000, 999999);
        $status = "A pagar";

        $diaContrato = $request->diaContrato;
        $mesContrato = $request->mesContrato;
        $anoContrato = $request->anoContrato;
        $dataContrato = "$anoContrato-$mesContrato-$diaContrato";

        Contrato::query()->create([
            'arquivo' => session('arquivo_contrato_temporario.filename'),
            'nm_contrato' => $nomeContrato,
            'vl_contrato' => tratarValor(session('contrato_temporario.valor')),
            'ds_tipo_plano' => session('contrato_temporario.tipoPlano'),
            'nr_parcelas' => session('contrato_temporario.parcelas'),
            'nr_tempo_duracao' => session('contrato_temporario.duracaoServico'),
            'nr_tempo_midia' => session('contrato_temporario.antecipacaoMidia'),
            'vl_rescisao' => tratarValor(session('contrato_temporario.valorRescisao')),
            'nr_tempo_rescisao' => session('contrato_temporario.tempoRescisao'),
            'nr_tempo_validade' => session('contrato_temporario.validadeContrato'),
            'dt_contrato' => date('Y-m-d'),
            'nr_token' => $token,
            'ds_status' => $status,
            'cd_controle_contrato' => $controleContrato,
        ]);

        $codigoContrato = Contrato::query()->where('cd_controle_contrato', $controleContrato)->get();

        Contratante::query()->create([
            'nm_contratante' => session('contrato_temporario.nomeContratante'),
            'cd_cnpj_contratante' => removerCaracteres(['.', '-', '/'], session('contrato_temporario.cnpjContratante')),
            'nm_email_contratante' => session('contrato_temporario.emailContratante'),
            'ds_tipo_estabelecimento' => session('contrato_temporario.tipoEstabelecimento'),
            'cd_controle_contratante' => $controleContratante,
            'cd_contrato' => $codigoContrato[0]->cd_contrato,
        ]);

        $codigoContratante = Contratante::query()->where('cd_controle_contratante', $controleContratante)->get();

        Representante::query()->create([
            'nm_representante' => session('contrato_temporario.nomeRepresentante'),
            'cd_cpf_representante' => removerCaracteres(['.', '/', '-'], session('contrato_temporario.cpfRepresentante')),
            'cd_contratante' => $codigoContratante[0]->cd_contratante
        ]);

        EnderecoContratante::query()->create([
            'nm_endereco' => session('contrato_temporario.enderecoContratante'),
            'nr_numero' => session('contrato_temporario.numeroContratante'),
            'nm_bairro' => session('contrato_temporario.bairroContratante'),
            'nm_cidade' => session('contrato_temporario.cidadeContratante'),
            'sg_uf' => session('contrato_temporario.uf'),
            'cd_contratante' => $codigoContratante[0]->cd_contratante
        ]);

        //$link = "http://localhost:8000/assinarContrato?controleContrato=$controleContrato";
        $link = url('/')."/assinarContrato/$controleContrato";

        return redirect()->route('enviarEmail',
            [
                'link' => $link,
                'token' => $token,
                'emailContratante' => session('contrato_temporario.emailContratante'),
                'nome' => session('contrato_temporario.nomeRepresentante'),
                'nomeContrato' => $nomeContrato
            ]);
    }

    public function assinar(Request $request, $controle_contrato)
    {

        //$controleContrato = $_REQUEST['controleContrato'];
        $controleContrato = $controle_contrato;

        $contrato = Contrato::query()->where('cd_controle_contrato', $controleContrato)->get();

        if($contrato[0]->ds_status == 'Pago'):
            return redirect()->route('conclusaoPagamento');
        endif;

        $contratante = Contratante::query()->where('cd_contrato', $contrato[0]->cd_contrato)->get();
        $representante = Representante::query()->where('cd_contratante', $contratante[0]->cd_contratante)->get();
        $endereco_contratante = EnderecoContratante::query()->where('cd_contratante', $contratante[0]->cd_contratante)->get();

        $data = $contrato[0]->dt_contrato;

        $data = explode('-', $data);

        $ano = $data[0];
        $mes = $data[1];
        $dia = $data[2];

        contratoParaAssinar(
            $contrato,
            $contratante,
            $representante,
            $endereco_contratante,
            $dia,
            $mes,
            $ano
        );

        /*
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
        */

        return redirect()->action('App\Http\Controllers\ContratoController@leitura');

    }

    public function leitura(Request $request)
    {
        $filename = session('contrato_para_assinar.filename');
        $nomeContratante = session('contrato_para_assinar.nomeContratante');
        $enderecoContratante = session('contrato_para_assinar.enderecoContratante');
        $numeroContratante = session('contrato_para_assinar.numeroContratante');
        $bairroContratante = session('contrato_para_assinar.bairroContratante');
        $cidadeContratante = session('contrato_para_assinar.cidadeContratante');
        $tipoEstabelecimento = session('contrato_para_assinar.tipoEstabelecimento');
        $uf = session('contrato_para_assinar.uf');
        $cnpjContratante = session('contrato_para_assinar.cnpjContratante');
        $nomeRepresentante = session('contrato_para_assinar.nomeRepresentante');
        $cpfRepresentante = session('contrato_para_assinar.cpfRepresentante');
        $valor = session('contrato_para_assinar.valor');
        $parcelas = session('contrato_para_assinar.parcelas');
        $duracaoServico = session('contrato_para_assinar.duracaoServico');
        $antecipacaoMidia = session('contrato_para_assinar.antecipacaoMidia');
        $tipoPlano = session('contrato_para_assinar.tipoPlano');
        $valorRescisao = session('contrato_para_assinar.valorRescisao');
        $tempoRescisao = session('contrato_para_assinar.tempoRescisao');
        $emailContratada = session('contrato_para_assinar.emailContratada');
        $emailContratante = session('contrato_para_assinar.emailContratante');
        $validadeContrato = session('contrato_para_assinar.validadeContrato');
        $diaContrato = session('contrato_para_assinar.diaContrato');
        $mesContrato = session('contrato_para_assinar.mesContrato');
        $anoContrato = session('contrato_para_assinar.anoContrato');
        $controleContrato = session('contrato_para_assinar.controleContrato');

        $mesMostrado = '';

        switch($mesContrato)
        {
            case 1:
                $mesMostrado = "Janeiro";
                break;
            case 2:
                $mesMostrado = "Fevereiro";
                break;
            case 3:
                $mesMostrado = "Março";
                break;
            case 4:
                $mesMostrado = "Abril";
                break;
            case 5:
                $mesMostrado = "Maio";
                break;
            case 6:
                $mesMostrado = "Junho";
                break;
            case 7:
                $mesMostrado = "Julho";
                break;
            case 8:
                $mesMostrado = "Agosto";
                break;
            case 9:
                $mesMostrado = "Setembro";
                break;
            case 10:
                $mesMostrado = "Outubro";
                break;
            case 11:
                $mesMostrado = "Novembro";
                break;
            case 12:
                $mesMostrado = "Dezembro";
                break;
        }

        //$filename = "contrato.pdf";

        $data = [
            'title' => 'Gerando um contrato'
        ];

        $html = '<span style="text-align:justify;"><b>CONTRATANTE: </b>'. $nomeContratante . ', com sede no endereço '. $enderecoContratante .', '. $numeroContratante. ', inscrito sob o CNPJ ' . $cnpjContratante.' Representado por ' . $nomeRepresentante . ', portador do documento de número ' . $cpfRepresentante . '.<br>' .
        '<b>CONTRATADA:</b> BOOAT TECNOLOGIA LTDA, com sede na RUA GUAIAÓ, 66, APARECIDA, SANTOS/SP - CEP 11035-260, inscrita sob o CNPJ 24.661.945/0001-12.<br>' .
        '<br>As partes identificadas acima têm, entre si, justo e acertado o presente contrato de divulgação para o setor de ramo '. $tipoEstabelecimento .', que se regerá pelas cláusulas seguintes, condições de preço, forma e termo de pagamento descritas no presente documento. <br>' .
        '<br><b>Cláusula Primeira – Do Objeto</b><br><b>Parágrafo Primeiro.</b> O presente Contrato tem como objeto a reserva e direito das informações empresariais da CONTRATANTE, na plataforma de tecnologia disponibilizada pela CONTRATADA, denominado “mapa”, no prazo estipulado neste instrumento. As informações serão divulgadas no “ponto exato” do endereço da CONTRATANTE, garantindo uso exclusivo do espaço na plataforma sem a possibilidade qualquer outro sobrepor.
        <br><b>Parágrafo Segundo.</b> É responsabilidade da CONTRATANTE a disponibilização de todo material digital incluindo: logotipo da empresa em alta qualidade, fotos e quaisquer outros arquivos solicitados pela CONTRATADA. O material deverá obedecer às especificações da plataforma.<br>' .
        '<br><b>Cláusula Segunda – Do Pagamento</b><br><b>Parágrafo Único.</b> O valor acordado será de R$ ' .$valor.' e deverá ser pago em '. $parcelas .' parcela(s) até a data de vencimento, através do link de pagamento enviado pela CONTRATADA.<br>' .
        '<br><b>Cláusula Terceira – Das Obrigações da Contratada</b><br><b>Parágrafo Primeiro.</b> A CONTRATADA se responsabiliza pelo desenvolvimento e publicação do estabelecimento em mapa no prazo máximo de <b>7 dias úteis</b> após a assinatura deste Contrato.
        <br><b>Parágrafo Segundo.</b> A CONTRATADA compromete-se a manter na plataforma, as informações comerciais da CONTRATANTE no prazo ajustado de ' . $duracaoServico . ' meses no formato “Ponto, Banner, Janela, Lista”.
        <b>Parágrafo Terceiro.</b> A CONTRATADA compromete-se a manter o software e informações do CONTRATANTE nos servidores do BOOAT pelo prazo ajustado de ' . $duracaoServico . ' meses a partir da assinatura deste contrato.<br>' .
        '<br><b>Cláusula Quarta – Das Obrigações da Contratante</b><br><b>Parágrafo Primeiro.</b> A CONTRATANTE compromete-se em realizar o pagamento do valor ajustado até a data de seu vencimento.
        <br><b>Parágrafo Segundo.</b> A CONTRATANTE compromete-se em enviar todo e qualquer material digital que corresponder a contratação do presente serviço nos termos do solicitado pela CONTRATADA com antecedência mínima de '. $antecipacaoMidia . ' dia(s) úteis.
        <br><b>Parágrafo Terceiro.</b> Caberá a CONTRATANTE informar à CONTRATADA sobre qualquer atualização de informações contidas em seu espaço publicado na plataforma, sempre que ocorrer qualquer alteração.
        <br><b>Parágrafo Quarto.</b> A CONTRATANTE se responsabiliza pelas informações comerciais contidas no seu espaço na plataforma, sendo essas disponibilizadas ao BOOAT no ato da contratação do seu plano '. $tipoPlano . ' e conferindo esta responsabilidade exclusivamente a CONTRATANTE.
        <br><b>Parágrafo Quinto.</b> A CONTRATANTE se responsabiliza a cumprir com as Políticas de Anúncios do BOOAT, e não veicular material de conteúdo proibido, sob pena de retirada do anúncio sem prejuízo de indenização em caso de perdas e danos pela CONTRATADA.
        <br><b>Parágrafo Sexto.</b> A CONTRATANTE garante que o uso do serviço não violará nenhuma lei aplicável ou direito de propriedade de terceiros.<br>' .
        '<br><br><b>Cláusula Quinta – Da Rescisão</b><br><b>Parágrafo Primeiro.</b> O presente instrumento poderá ser rescindido a qualquer momento por comum acordo entre as partes, dando-se por quitadas as obrigações.
        <br><b>Parágrafo Segundo.</b> O presente instrumento poderá ser rescindido unilateralmente caso qualquer uma das partes descumpra o disposto neste contrato, bem como, em caso de descumprimento de qualquer dos documentos que o acompanham.
        <br><b>Parágrafo Terceiro.</b> Caso o contrato seja rescindido pela CONTRATANTE, será obrigada a pagar à CONTRATADA os valores devidos de forma proporcional referentes aos serviços de desenvolvimento e divulgação que tenham sido prestados pela CONTRATADA até a data de rescisão deste contrato, conforme previsões contratuais definidas neste instrumento, bem como deverá pagar multa equivalente a '. $valorRescisao .'% do valor proporcional do contrato.
        <br><b>Parágrafo Quarto.</b> Caso a CONTRATADA dê motivo a rescisão do contrato, será obrigada a devolver a CONTRATANTE, os valores pagos de forma proporcional e correspondente aos serviços que não foram efetivamente prestados, conforme previsão contratual definidas no presente instrumento, no prazo de '. $tempoRescisao .' dias corridos da rescisão contratual.
        <br><b>Parágrafo Quinto.</b> Serão considerados válidos e eficazes os pedidos de desistência ou cancelamento dos serviços, enviados para o e-mail da CONTRATADA: '.$emailContratada.' e/ou para o e-mail do(a) CONTRATANTE: '.$emailContratante.' com confirmações de leitura, ou ainda, por meio dos correios com AR.<br>' .
        '<br><b>Cláusula Sexta – Das Disposições Gerais</b><br><b>Parágrafo Primeiro.</b> A CONTRATANTE concorda expressamente pleno acordo com todas as cláusulas presentes nesse contrato e declara entender e aceitar todas as condições estabelecidas nos princípios de publicidade, Política de Privacidade e Termo de Uso que consta anexo a este contrato antes de efetivar a contratação.
        <br><b>Parágrafo Segundo.</b> A CONTRATANTE se compromete a seguir o Manual do Anunciante e demais Políticas Internas estabelecidas pela CONTRATADA.
        <br><b>Parágrafo Terceiro.</b> Qualquer serviço solicitado pelo (a) CONTRATANTE que não esteja englobado no objeto do presente contrato, será realizado pela CONTRATADA mediante aprovação formal de orçamento complementar.
        <br><b>Parágrafo Quarto.</b> A partir da assinatura deste acordo, a CONTRATANTE autoriza expressamente a CONTRATADA o uso e reprodução da marca, imagem, foto, nome, logotipo e quaisquer outros arquivos inerentes à divulgação na plataforma, de forma irrestrita, a nível nacional, até o encerramento da vigência formal deste contrato.
        <br><b>Parágrafo Quinto.</b> A CONTRATANTE se compromete a atuar em consonância com a Lei Geral de Proteção de Dados (Lei 13.709/2018), garantindo a confidencialidade de quaisquer dados pessoais que possam vir a ser tratados em decorrência deste instrumento.<br>'.
        '<br><b>Cláusula Sétima – Do Prazo</b><br><b>Parágrafo Único.</b> Este Contrato terá validade de '.$validadeContrato.' meses a partir da data de sua assinatura. <br>'.
        '<br><b>Cláusula Oitava – Da Forma</b><br><b>Parágrafo Único.</b> As partes declaram e concordam que o presente acordo, é firmado por meio digital e representa a integralidade dos termos entre elas acordados, substituindo quaisquer outros acordos anteriores formalizados por outro meio de comunicação, sendo mensagem, verbal ou digital nos termos dos arts. 107, 219 e 220 do Código Civil.<br>'.
        '<br><b>Cláusula Nona – Do Foro</b><br><b>Parágrafo Único.</b> Para dirimir quaisquer controvérsias oriundas do Contrato, as partes elegem o foro da comarca de Santos/SP, com exclusão de qualquer outro por mais privilegiado que seja.';;

        $pdf = new TCPDF;

        $pdf::SetTitle('Contratando');
        $pdf::AddPage();
        $pdf::writeHTML('<span style="text-align:center;"><b>CONTRATO DE DESENVOLVIMENTO E DIVULGAÇÃO</b><br>', true, false, true, false, "");
        $pdf::Ln(5);
        $pdf::writeHTML($html, true, false, true, false, "");
        $pdf::Write(10, "Santos, São Paulo - $diaContrato de $mesMostrado de $anoContrato.", '', 0, 'R');

        $pdf::Output(public_path($filename), "F");

        /*
        $dados= [
            'nomeContratante' => $nomeContratante,
            'enderecoContratante' => $enderecoContratante,
            'numeroContratante' => $numeroContratante,
            'bairroContratante' => $bairroContratante,
            'cidadeContratante' => $cidadeContratante,
            'uf' => $uf,
            'cnpjContratante' => $cnpjContratante,
            'tipoEstabelecimento' => $tipoEstabelecimento,
            'nomeRepresentante' => $nomeRepresentante,
            'cpfRepresentante' => $cpfRepresentante,
            'valor' => $valor,
            'parcelas' => $parcelas,
            'duracaoServico' => $duracaoServico,
            'antecipacaoMidia' => $antecipacaoMidia,
            'tipoPlano' => $tipoPlano,
            'valorRescisao' => $valorRescisao,
            'tempoRescisao' => $tempoRescisao,
            'emailContratada' => "booat.ads@booat.com.br",
            'emailContratante' => $emailContratante,
            'validadeContrato' => $validadeContrato,
            'diaContrato' => $diaContrato,
            'mesContrato' => $mesContrato,
            'anoContrato' => $anoContrato,
            'controleContrato' => $controleContrato,
            'pdf' => public_path($filename),
        ];
        */

        return redirect()->route('leituraContrato');

    }

    public function verificarToken(Request $request)
    {
        $controleContrato = session('contrato_para_assinar.controleContrato');

        $contrato = Contrato::query()->where('cd_controle_contrato', $controleContrato)->get();

        $tokenBanco = $contrato[0]->nr_token;

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
            Assinatura::query()->create([
                'nm_pessoa' => $request->nomeAssinatura,
                'cd_cpf_pessoa' => removerCaracteres(['.', '-', '/'], $request->cpfAssinatura),
                'dt_assinatura' => $dataAssinatura,
                'cd_contrato' => $contrato[0]->cd_contrato
            ]);
            return redirect()->route('pagamento', ['contrato' => $contrato[0]->cd_contrato]);
        }
        else
        {
            return redirect()->route('termos', ['erro' => 'token']);
        }
    }

    public function enviarDiscrepancias(Request $request)
    {
        $link = $request->link;
        $controleContrato = $request->controleContrato;
        $enderecoEmail = $request->emailContratante;
        $nome = session('contrato_para_assinar.nomeContratante');
        $cpf_cnpj = !empty($request->cpfCnpjContratante) ? removerCaracteres(['.', '-', '/'], $request->cpfCnpjContratante) : '';
        $discrepancias = $request->discrepancias;

        $contrato = Contrato::query()->where('cd_controle_contrato', $controleContrato)->get();
        $contratante = Contratante::query()->where('cd_contrato', $contrato[0]->cd_contrato)->get();

        $conteudo_email = "
            <div>Código de Controle do Contrato: {$controleContrato}</div>
            <div>Contratente: {$contratante[0]->nm_contratante}</div>
            <div>Discrepancias: {$discrepancias}</div>
        ";

        $email = new Mail();
        $email->setFrom("booat.ads1@booat.com.br", "Comercial Booat");
        $email->setSubject($nome);
        $email->addTo($enderecoEmail, "Discrepâncias Contrato");
        $email->addContent(
            "text/html", "$conteudo_email"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            /*

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
            $status = "Email enviado com sucesso";
            */
            return response()->json(['status' => 'ok', 'response' => $response->body()]);
        } catch (Exception $e) {
            //$status = "Houve uma falha na tentativa de envio de email, tente novamente";
            return response()->json(['status' => 'erro']);
        }

        limparContratoTemporario();

        //return redirect()->route('conclusaoEmail', ['resultado' => $status]);
        return redirect()->route('conclusaoEmail', ['resultado' => $status]);
    }

    public function contratoAssinado(Request $request)
    {
        $nomeContrato = $request->nomeContrato;
        $valor = $request->valor;
        $parcelas = $request->parcelas;
        $duracaoServico = $request->duracaoServico;
        $antecipacaoMidia = $request->antecipacaoMidia;
        $tipoPlano = $request->tipoPlano;
        $valorRescisao = $request->valorRescisao;
        $tempoRescisao = $request->tempoRescisao;
        $dataContrato = $request->dataContrato;
        $tempoValidade = $request->tempoValidade;
        $nomeContratante = $request->nomeContratante;
        $cnpjContratante = $request->cnpjContratante;
        $tipoEstabelecimento = $request->tipoEstabelecimento;
        $emailContratante = $request->emailContratante;
        $enderecoContratante = $request->enderecoContratante;
        $numeroContratante = $request->numeroContratante;
        $bairroContratante = $request->bairroContratante;
        $cidadeContratante = $request->cidadeContratante;
        $uf = $request->uf;
        $nomeRepresentante = $request->nomeRepresentante;
        $cpfRepresentante = $request->cpfRepresentante;
        $nomeAssinatura = $request->nomeAssinatura;
        $cpfAssinatura = $request->cpfAssinatura;
        $dataAssinatura = $request->dataAssinatura;
        $emailContratada = "booat.ads@booat.com.br";

        $data = explode('-', $dataContrato);

        $diaContrato = $data[2];
        $mesContrato = $data[1];
        $anoContrato = $data[0];

        $mesMostrado = '';

        $horario = explode(' ', $dataAssinatura);
        $horario = $horario[1];

        switch($mesContrato)
        {
            case 1:
                $mesMostrado = "Janeiro";
                break;
            case 2:
                $mesMostrado = "Fevereiro";
                break;
            case 3:
                $mesMostrado = "Março";
                break;
            case 4:
                $mesMostrado = "Abril";
                break;
            case 5:
                $mesMostrado = "Maio";
                break;
            case 6:
                $mesMostrado = "Junho";
                break;
            case 7:
                $mesMostrado = "Julho";
                break;
            case 8:
                $mesMostrado = "Agosto";
                break;
            case 9:
                $mesMostrado = "Setembro";
                break;
            case 10:
                $mesMostrado = "Outubro";
                break;
            case 11:
                $mesMostrado = "Novembro";
                break;
            case 12:
                $mesMostrado = "Dezembro";
                break;
        }

        $filename = "contrato.pdf";

        $data = [
            'title' => 'Gerando um contrato'
        ];

        $html = '<span style="text-align:justify;"><b>CONTRATANTE: </b>'. $nomeContratante . ', com sede no endereço '. $enderecoContratante .', '. $numeroContratante . ', inscrito sob o CNPJ ' . $cnpjContratante.' Representado por ' . $nomeRepresentante . ', portador do documento de número ' . $cpfRepresentante . '.<br>' .
        '<b>CONTRATADA:</b> BOOAT TECNOLOGIA LTDA, com sede na RUA GUAIAÓ, 66, APARECIDA, SANTOS/SP - CEP 11035-260, inscrita sob o CNPJ 24.661.945/0001-12.<br>' .
        '<br>As partes identificadas acima têm, entre si, justo e acertado o presente contrato de divulgação para o setor de ramo '. $tipoEstabelecimento .', que se regerá pelas cláusulas seguintes, condições de preço, forma e termo de pagamento descritas no presente documento. <br>' .
        '<br><b>Cláusula Primeira – Do Objeto</b><br><b>Parágrafo Primeiro.</b> O presente Contrato tem como objeto a reserva e direito das informações empresariais da CONTRATANTE, na plataforma de tecnologia disponibilizada pela CONTRATADA, denominado “mapa”, no prazo estipulado neste instrumento. As informações serão divulgadas no “ponto exato” do endereço da CONTRATANTE, garantindo uso exclusivo do espaço na plataforma sem a possibilidade qualquer outro sobrepor.
        <br><b>Parágrafo Segundo.</b> É responsabilidade da CONTRATANTE a disponibilização de todo material digital incluindo: logotipo da empresa em alta qualidade, fotos e quaisquer outros arquivos solicitados pela CONTRATADA. O material deverá obedecer às especificações da plataforma.<br>' .
        '<br><b>Cláusula Segunda – Do Pagamento</b><br><b>Parágrafo Único.</b> O valor acordado será de R$' .$valor.' e deverá ser pago em '. $parcelas .' parcela(s) até a data de vencimento, através do link de pagamento enviado pela CONTRATADA.<br>' .
        '<br><b>Cláusula Terceira – Das Obrigações da Contratada</b><br><b>Parágrafo Primeiro.</b> A CONTRATADA se responsabiliza pelo desenvolvimento e publicação do estabelecimento em mapa no prazo máximo de <b>7 dias úteis</b> após a assinatura deste Contrato.
        <br><b>Parágrafo Segundo.</b> A CONTRATADA compromete-se a manter na plataforma, as informações comerciais da CONTRATANTE no prazo ajustado de ' . $duracaoServico . ' meses no formato “Ponto, Banner, Janela, Lista”.
        <b>Parágrafo Terceiro.</b> A CONTRATADA compromete-se a manter o software e informações do CONTRATANTE nos servidores do BOOAT pelo prazo ajustado de ' . $duracaoServico . ' meses a partir da assinatura deste contrato.<br>' .
        '<br><b>Cláusula Quarta – Das Obrigações da Contratante</b><br><b>Parágrafo Primeiro.</b> A CONTRATANTE compromete-se em realizar o pagamento do valor ajustado até a data de seu vencimento.
        <br><b>Parágrafo Segundo.</b> A CONTRATANTE compromete-se em enviar todo e qualquer material digital que corresponder a contratação do presente serviço nos termos do solicitado pela CONTRATADA com antecedência mínima de '. $antecipacaoMidia . ' dia(s) úteis.
        <br><b>Parágrafo Terceiro.</b> Caberá a CONTRATANTE informar à CONTRATADA sobre qualquer atualização de informações contidas em seu espaço publicado na plataforma, sempre que ocorrer qualquer alteração.
        <br><b>Parágrafo Quarto.</b> A CONTRATANTE se responsabiliza pelas informações comerciais contidas no seu espaço na plataforma, sendo essas disponibilizadas ao BOOAT no ato da contratação do seu plano '. $tipoPlano . ' e conferindo esta responsabilidade exclusivamente a CONTRATANTE.
        <br><b>Parágrafo Quinto.</b> A CONTRATANTE se responsabiliza a cumprir com as Políticas de Anúncios do BOOAT, e não veicular material de conteúdo proibido, sob pena de retirada do anúncio sem prejuízo de indenização em caso de perdas e danos pela CONTRATADA.
        <br><b>Parágrafo Sexto.</b> A CONTRATANTE garante que o uso do serviço não violará nenhuma lei aplicável ou direito de propriedade de terceiros.<br>' .
        '<br><br><b>Cláusula Quinta – Da Rescisão</b><br><b>Parágrafo Primeiro.</b> O presente instrumento poderá ser rescindido a qualquer momento por comum acordo entre as partes, dando-se por quitadas as obrigações.
        <br><b>Parágrafo Segundo.</b> O presente instrumento poderá ser rescindido unilateralmente caso qualquer uma das partes descumpra o disposto neste contrato, bem como, em caso de descumprimento de qualquer dos documentos que o acompanham.
        <br><b>Parágrafo Terceiro.</b> Caso o contrato seja rescindido pela CONTRATANTE, será obrigada a pagar à CONTRATADA os valores devidos de forma proporcional referentes aos serviços de desenvolvimento e divulgação que tenham sido prestados pela CONTRATADA até a data de rescisão deste contrato, conforme previsões contratuais definidas neste instrumento, bem como deverá pagar multa equivalente a '. $valorRescisao .'% do valor proporcional do contrato.
        <br><b>Parágrafo Quarto.</b> Caso a CONTRATADA dê motivo a rescisão do contrato, será obrigada a devolver a CONTRATANTE, os valores pagos de forma proporcional e correspondente aos serviços que não foram efetivamente prestados, conforme previsão contratual definidas no presente instrumento, no prazo de '. $tempoRescisao .' dias corridos da rescisão contratual.
        <br><b>Parágrafo Quinto.</b> Serão considerados válidos e eficazes os pedidos de desistência ou cancelamento dos serviços, enviados para o e-mail da CONTRATADA: '.$emailContratada.' e/ou para o e-mail do(a) CONTRATANTE: '.$emailContratante.' com confirmações de leitura, ou ainda, por meio dos correios com AR.<br>' .
        '<br><b>Cláusula Sexta – Das Disposições Gerais</b><br><b>Parágrafo Primeiro.</b> A CONTRATANTE concorda expressamente pleno acordo com todas as cláusulas presentes nesse contrato e declara entender e aceitar todas as condições estabelecidas nos princípios de publicidade, Política de Privacidade e Termo de Uso que consta anexo a este contrato antes de efetivar a contratação.
        <br><b>Parágrafo Segundo.</b> A CONTRATANTE se compromete a seguir o Manual do Anunciante e demais Políticas Internas estabelecidas pela CONTRATADA.
        <br><b>Parágrafo Terceiro.</b> Qualquer serviço solicitado pelo (a) CONTRATANTE que não esteja englobado no objeto do presente contrato, será realizado pela CONTRATADA mediante aprovação formal de orçamento complementar.
        <br><b>Parágrafo Quarto.</b> A partir da assinatura deste acordo, a CONTRATANTE autoriza expressamente a CONTRATADA o uso e reprodução da marca, imagem, foto, nome, logotipo e quaisquer outros arquivos inerentes à divulgação na plataforma, de forma irrestrita, a nível nacional, até o encerramento da vigência formal deste contrato.
        <br><b>Parágrafo Quinto.</b> A CONTRATANTE se compromete a atuar em consonância com a Lei Geral de Proteção de Dados (Lei 13.709/2018), garantindo a confidencialidade de quaisquer dados pessoais que possam vir a ser tratados em decorrência deste instrumento.<br>'.
        '<br><b>Cláusula Sétima – Do Prazo</b><br><b>Parágrafo Único.</b> Este Contrato terá validade de '.$tempoValidade.' meses a partir da data de sua assinatura. <br>'.
        '<br><b>Cláusula Oitava – Da Forma</b><br><b>Parágrafo Único.</b> As partes declaram e concordam que o presente acordo, é firmado por meio digital e representa a integralidade dos termos entre elas acordados, substituindo quaisquer outros acordos anteriores formalizados por outro meio de comunicação, sendo mensagem, verbal ou digital nos termos dos arts. 107, 219 e 220 do Código Civil.<br>'.
        '<br><b>Cláusula Nona – Do Foro</b><br><b>Parágrafo Único.</b> Para dirimir quaisquer controvérsias oriundas do Contrato, as partes elegem o foro da comarca de Santos/SP, com exclusão de qualquer outro por mais privilegiado que seja.';;

        $pdf = new TCPDF;

        $pdf::SetTitle('Contratando');
        $pdf::AddPage();
        $pdf::writeHTML('<span style="text-align:center;"><b>CONTRATO DE DESENVOLVIMENTO E DIVULGAÇÃO</b><br>', true, false, true, false, "");
        $pdf::Ln(5);
        $pdf::writeHTML($html, true, false, true, false, "");
        $pdf::Write(10, "Santos, São Paulo - $diaContrato de $mesMostrado de $anoContrato.", '', 0, 'R');
        $pdf::Ln(20);
        $assinatura = 'Contrato assinado pelo Sr.(a) '. $nomeAssinatura .', portador(a) do documento de número '. $cpfAssinatura.' na data de ' . $diaContrato .' de '. $mesMostrado .' de '. $anoContrato .'. Às '. $horario .'.';
        $pdf::Write(0, $assinatura, '', 0, 'L');


        $pdf::Output(public_path($filename), "F");

        return redirect()->route('conclusaoPagamento', ['pdf' => public_path($filename)]);
    }
}
