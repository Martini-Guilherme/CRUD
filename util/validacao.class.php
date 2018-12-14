<?php
class Validacao
{
    public static function validarNome($v)
    {
        $exp = "/^[A-z  ]{2,30}$/";
        return preg_match($exp, $v);
    }
    
}
