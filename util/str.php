<?php

class str {

    static function isArrayNotEmtpy($value) {
        if (is_null($value)) {
            return FALSE;
        }
        if (!is_array($value)) {
            return FALSE;
        }
        if (count($value) < 1) {
            return FALSE;
        }
        return TRUE;
    }

    static function IsNullOrEmptyString($value) {
        if (!isset($value) || is_null($value)) {
            return true;
        }
        if (trim($value === '')) {
            return true;
        }
        // return (trim($value) === '');
        return false;
    }

    static function IsValidKey($value) {
        if (str::IsNullOrEmptyString($value)) {
            return false;
        };

        if ($value == 0) {
            return false;
        }

        if (!is_numeric($value)) {
            return false;
        }
        return true;
    }

    static function converterVirgulaParaPonto($valor) {
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }

    static function randomToken($len) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $len; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }
        return $token;
    }

}
