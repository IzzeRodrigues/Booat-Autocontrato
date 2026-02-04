<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src=" {{ asset('/js/jquery-1.12.2.min.js') }} "></script>
    <script src=" {{ asset('/js/jquery.mask.min.js') }} "></script>
    <script src="{{ asset('/js/jquery.maskMoney.js') }}"></script>

    <script src=" {{ asset('/js/vue2/es6-promise.auto.js') }} "></script>

    <?php
    echo $_SERVER['HTTP_HOST'] == 'localhost'
        ? '<script src="'.asset("/js/vue2/vue.js").'"></script>'
        : '<script src="'.asset("/js/vue2/vue2_prod.js").'"></script>';
    ?>

    <script src="{{ asset('/js/vue2/vuex.js') }}"></script>

    <script src="{{ asset('/js/vue2/lodash.min.js') }} "></script>
    <script src="{{ asset('/js/vue2/vuex-persist.js') }} "></script>

    <title>@yield('titulo')</title>
</head>
<body>
    <div class="corpo pb-3 pt-3 container-fluid d-flex flex-column justify-content-between">
        <div>
            <div class="col-2">
                <a href="/">
                    <img src="images/logoBooat.png" class="img-fluid col-9">
                </a>
            </div>
            <hr>
        </div>
        <div class="col-10 d-flex flex-column align-self-center align-items-center">
            @yield('conteudo')
        </div>
        <div>
            <hr>
            <div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 fs-5 me-3">POWERED BY PAGSEGURO</p>
                <img src="images/pagseguropci.png" class="ms-3 img-fluid col-1">
            </div>
        </div>
    </div>

    <div class="whatsapp-float">
        <a href="https://api.whatsapp.com/send?phone=5511937787775" target="_blank" id="btn-whatsapp" onclick="/*gtag_report_conversion('https://api.whatsapp.com/send?phone=5518981387700')*/">
            <img src="{{ asset('images/whats.png') }}" alt="WhatsApp">
        </a>
    </div>

    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>

</body>
</html>
