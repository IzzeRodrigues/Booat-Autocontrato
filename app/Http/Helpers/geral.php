<?php

if(!function_exists('tratarValor')){
    function tratarValor($valor){
        if(!empty($valor)):
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
            return $valor;
        else:
            return 0;
        endif;
    }
}

if(!function_exists('formataDataFormatoAmericano')){
    function formataDataFormatoAmericano($data)
    {
        return implode('-', array_reverse(explode('/', $data)));
    }
}

if(!function_exists('removerCaracteres')){
    function removerCaracteres(array $caracteres, string $valor)
    {
        if(!empty($caracteres)):
            foreach ($caracteres as $caractere):
                $valor = str_replace($caractere, '', $valor);
            endforeach;
        endif;

        return $valor;
    }
}
