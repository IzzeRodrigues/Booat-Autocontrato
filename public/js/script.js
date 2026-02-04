function adjustDivHeight() {
    // var formHeight = $('form').is(':visible') ? $('form').height() : 0;
    // $('#expandable-div').css('height', formHeight + '-5px');
    var teste = document.getElementById("form");
    teste.style.position = 'relative';
    var teste1 = document.getElementById("botao");
    teste1.style.display = 'none';
    
}

$(function () {
    'use strict';
    $('[type="submit"]').on('click', function (e) {
        if ($(this).hasClass('pix')) {
            e.preventDefault();
            $(this).animate({ bottom: 10 }, 300, function () {
                $('form').addClass('appear').delay(10);
                $(this).removeClass('pix').val('Sair');
                $('#minhaImagem').fadeIn();
                $('#teste').fadeIn();
                $('#teste2').fadeIn();
                adjustDivHeight();
            });
        }
    });
});









