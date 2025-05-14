<?php

//namespace App\Helpers;
use App\Models\User;


if (!function_exists('mrc_calc_time')) {

    function mrc_calc_time($dataStart)
    {
        $dataStart = strtotime($dataStart);
        $dateEnd = strtotime(date('Y-m-d'));

        $datadiff = abs(($dateEnd) - ($dataStart));
        $years = floor($datadiff / (365*60*60*24));
        $months = floor(($datadiff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($datadiff - $years*365*60*60*24 - $months*30*60*60*24) / (60*60*24));

        return $years. " anos, ". $months. " meses " . "e ". $days. " dia(s)";
    }
}


if (!function_exists('mrc_turn_data')) {

    function mrc_turn_data($dataBd)
    {
        $dataTurn = implode('/', array_reverse(array_merge(explode('-', $dataBd))));
        return $dataTurn;
    }
}

if (!function_exists('mrc_turn_value')) {

    function mrc_turn_value($valueBd)
    {
        $dataValue = number_format($valueBd, '2', ',', '.');
        return $dataValue;
    }
}


if (!function_exists('mrc_calc_percentaf')) {

    function mrc_calc_percentaf($val_tot, $val_parc)
    {
        if($val_tot != 0){
            $percentage = (($val_parc * 100) / $val_tot);
        } else {
            $percentage = 0;
        }

        $percentformated = number_format($percentage, '2', ',', '.');
        return $percentformated;
    }
}


if (!function_exists('mrc_extract_week')) {

    function mrc_extract_week($valsemana)
    {
        $numweek = $valsemana;

        switch($numweek) {
            case 1:
                $semana = "primeira";
                break;
                case 2:
                    $semana = "segunda";
                    break;
                case 3:
                    $semana = "terceira";
                    break;
                case 4:
                    $semana = "quarta";
                    break;
                case 5:
                    $semana = "quinta";
                    break;
                default:
                $semana = "Semana inválida!";
        }

        return $semana;
    }
}


if (!function_exists('mrc_extract_month')) {

    function mrc_extract_month($dataBd)
    {
        $month = date("m", strtotime($dataBd));

        switch ($month) {
            case 1:
                $mescompra = "JAN";
                break;
            case 2:
                $mescompra = "FEV";
                break;
            case 3:
                $mescompra = "MAR";
                break;
            case 4:
                $mescompra = "ABR";
                break;
            case 5:
                $mescompra = "MAI";
                break;
            case 6:
                $mescompra = "JUN";
                break;
            case 7:
                $mescompra = "JUL";
                break;
            case 8:
                $mescompra = "AGS";
                break;
            case 9:
                $mescompra = "SET";
                break;
            case 10:
                $mescompra = "OUT";
                break;
            case 11:
                $mescompra = "NOV";
                break;
            case 12:
                $mescompra = "DEZ";
                break;
            default:
                $mescompra = "Mês inválido!";
          }

        return $mescompra;
    }
}


if (!function_exists('mrc_encrypt_decrypt')) {

    function mrc_encrypt_decrypt($action, $string)
    {
        // https://www.allphptricks.com/how-to-encrypt-decrypt-string-in-php/
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '$7PHKqGt$yRlPjyt89rds4ioSDsglpk/';
        $secret_iv = '$QG8$hj7TRE2allPHPlBbrthUtoiu23bKJYi/';
        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    if (!function_exists('mrc_genero_estadocivil')) {

        function mrc_genero_estadocivil($genero, $estadoCivil)
        {

            if($genero == "masculino"){
                $generoEstadoCivil = str_replace("o(a)","o" ,$estadoCivil);
            }else{
                $generoEstadoCivil = str_replace("o(a)","a" ,$estadoCivil);
            }

            return $generoEstadoCivil;
        }
    }

    if (!function_exists('mrc_search_analista')) {

        function mrc_search_analista($id)
        {
            $nomeanalista = User::where('id', '=', $id)->pluck('nomecompleto');
            return $nomeanalista[0];

        }
    }

}
