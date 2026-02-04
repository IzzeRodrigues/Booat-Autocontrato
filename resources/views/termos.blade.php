@extends('padraoCliente')

@section('titulo')
Termos de serviço
@endsection

@section('conteudo')

        <div class="col-6" id="vmTermos">
            <h3 class="text-center my-4 booat">Vamos assinar o seu contrato?</h3>
            <p class="text-center text-muted">Leia com atenção os termos de uso abaixo</p>

            <div class="">
                <div class="d-flex flex-column justify-content-center">

                    <textarea name="termos" id="termos" rows="12" disabled readonly style="resize: none">

    TERMOS DE USO

    Olá, seja bem-vindo a Booat!
    Vale lembrá-lo que o acesso ao conteúdo deste website dependerá de sua prévia e expressa concordância com os Termos de Uso e Políticas de Privacidade.
    A permanência em nosso website suscita a aceitação automática de nossos termos!
    Os Termos de Uso apresentam as "Condições Gerais" aplicáveis ao uso da plataforma online disponibilizada pela Booat Tecnologia.

    Como funciona o AutoContrato da Booat?

    O AutoContrato é uma plataforma online que se destina a elaboração de contratos automatizados, através das informações que você fornece à nossa equipe comercial.
    A plataforma é de uso exclusivo da Booat.
    Seu uso está condicionado à Prestação de Serviço da Booat Tecnologia, e implicará o preenchimento dos dados pessoais pelo próprio usuário, e, posteriormente, assinatura de nosso contrato de Desenvolvimento e Divulgação.

    Quem pode utilizar nossa plataforma?

    Qualquer pessoa maior de idade pode utilizar os serviços do Booat Tecnologia. Não é autorizada a participação de usuários menores de 18 (dezoito) anos de idade.
    Caso seja verificada eventual infração desta disposição, a Booat tomará as medidas necessárias. Ressaltamos desde já que a informação incorreta de dados pessoais, é crime passível de punição, nos termos da legislação pátria.
    Você pode acessar o AutoContrato através da criação de um perfil, utilizando-se de um nome de usuário ou e-mail e senha, nessa etapa você será automaticamente direcionado a nossa página na qual você deverá fornecer seus dados para elaboração de nosso contrato.
    Em caso de suspeita de uso indevido ou não autorizado de sua conta, o usuário deve notificar imediatamente a Booat através do e-mail legal@booat.com.br.
    A Booat obriga-se a utilizar as informações cadastrais fornecidas pelo usuário exclusivamente na forma e nos limites do quanto necessário para a realização de nossos serviços na forma aqui prevista, quaisquer atualizações referentes a maneira como tratamos seus dados será informada expressamente.

    O que você concorda quando consente com nossos Termos?

    O usuário compromete-se:
    1. Fornecer informações verdadeiras, precisas, atualizadas e completas no momento de seu cadastro de acesso;
    2. Manter e atualizar suas informações de forma a mantê-las verdadeiras, exatas e completas;
    3. Se declara responsável por qualquer informação falsa, incorreta, desatualizada ou incompleta fornecida. Caso a Booat tenha razões suficientes para suspeitar da autenticidade e/ou da exatidão de tais informações, poderá tomar as medidas cabíveis;
    4. Permitir que a Booat entregue os dados cadastrais das empresas cadastradas para nossos usuários, para fins comerciais nos termos do estabelecido em contrato. Os dados cadastrais que poderão ser fornecidos são: nome do estabelecimento (razão social ou nome fantasia), endereço, CNPJ, telefone e e-mail.

    Pagamentos

    Os usuários declaram estar plenamente cientes e concordam que todos os valores referentes a prestação de serviço da Booat só poderão ser arrecadados com a utilização do serviço de pagamentos online PagSeguro, por meio de cartão de crédito, débito em conta ou boleto bancário, ou ainda, através de PIX.
    Caso algum contrato do usuário com a Booat seja declarado inválido por violação dos Termos de Uso, violação de contrato, violação de normas legais ou por ordem judicial, os valores pagos poderão não ser reembolsados.
    Tendo em vista que os serviços de meios de pagamento online e de cartões de crédito são independentes da Booat Tecnologia, estes possuem exclusiva responsabilidade pelos pagamentos processados e respondem, inclusive pelas falhas de cartões de crédito.
    Salvo disposição em contrário, todas as taxas são cotadas em Reais (R$).

    Legislação aplicável

    Estes termos de serviço são regidos única e exclusivamente pelas leis brasileiras, sendo que qualquer ação judicial relativa à sua interpretação ou aplicação deverá ser processada e julgada pelo Poder Judiciário Brasileiro.
    Em caso de conflito de leis estaduais ou municipais, para a interpretação de qualquer dúvida ou litígio, deverá sempre prevalecer a legislação do Estado de São Paulo.
                    </textarea>

                    <form class='col-12' action='/bancoVerificacao' method="POST">
                        @csrf

                        <div class='form-check mt-4 oculto' id="box-checkbox">
                            <label><input class='form-check-input cursor radio' type='checkbox' id='flexCheckDefault' required><p class='ms-2 text-muted mutarTexto m-0'>Eu aceito os termos de uso</p></label>
                        </div>
                        <div style="height: 15px;"></div>

                        <div class="g-recaptcha" data-sitekey="6LcDRFMoAAAAAO5Ne8jmpBpa7QER4RO5NMb6PZ_v"></div>

                        <div class=' d-flex flex-column align-items-center mt-5'>
                            <p class='text-start text-muted'>Insira o seu nome, documento e token que foi enviado por email para confirmação</p>
                            <div class='d-flex flex-row justify-content-around'>
                                <input type='text' name='nomeAssinatura' id='nomeAssinatura' placeholder='Nome' class='inputLogin py-2 col-3'>
                                <input type='text' name='cpfAssinatura' id='cpfAssinatura' placeholder='CPF' class='inputLogin py-2 col-4'>
                                <input type='text' name='tokenAssinatura' id='tokenAssinatura' placeholder='Token' class='inputLogin py-2 col-3'>
                            </div>
                            <input type='hidden' name='controleContrato' value='{{ session('contrato_para_assinar.controleContrato') }}'>
                            <p><a href='https://wa.me/5511937787775/?text=Estou%20com%20um%20problema%20no%20meu%20contrato' target="_blank" class='booat'>Não recebi um e-mail</a></p>
                        </div>
                        <button @click="verificarCampos" class='d-flex mx-auto mt-5 botaoLogin botaoBooat rounded-2 align-items-center justify-content-center' type='submit'>Validar assinatura</button>
                    </form>

                </div>
            </div>
        </div>

        <script defer src="https://www.google.com/recaptcha/api.js"></script>
        <script type="module" src="{{ asset('js/termos.js') }}"></script>

        @component('components.modal.modal')
            @slot('id_modal', 'modalTokenInvalido')
            @slot('titulo_modal', 'Erro')
            @slot('corpo_modal')
                Token Inválido
            @endslot
            @slot('botoes_modal')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            @endslot
        @endcomponent

        @component('components.modal.modal')
            @slot('id_modal', 'ErroModal')
            @slot('titulo_modal', 'Erro')
            @slot('corpo_modal')
                @{{ mensagem_erro }}
            @endslot
            @slot('botoes_modal')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            @endslot
        @endcomponent

@endsection
