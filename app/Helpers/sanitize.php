<?php

use App\Support\Cropper;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

if (! function_exists('convertStringToDouble')) {
    function convertStringToDouble(?string $param)
    {
        if(empty($param)){
            return 0.0;
        }

        return floatval(str_replace([','], '.', str_replace(['.'], '', $param)));
    }
}

if (! function_exists('clearField')) {
    function clearField(?string $param)
    {
        if(empty($param)){
            return '';
        }

        return str_replace(['.','-','/','(',')',' ','_','+'], '', $param);
    }
}

if (! function_exists('convertDocument')) {
    function convertDocument(?string $param)
    {
        return substr($param,0,3) . '.' . substr($param,3,3) . '.' . substr($param,6,3) . '-' . substr($param,9);
    }
}

if (! function_exists('convertDocumentCompany')) {
    function convertDocumentCompany(?string $param)
    {
        return substr($param,0,2) . '.' . substr($param,2,3) . '.' . substr($param,5,3) . '/' . substr($param,8,4) . '-'. substr($param,12);
    }
}

if (! function_exists('convertZipcode')) {
    function convertZipcode(?string $param)
    {
        return substr($param,0,2) . '.' . substr($param,2,3) . '-' . substr($param,5,3);
    }
}

if (! function_exists('convertPlate')) {
    function convertPlate(?string $param)
    {
        return substr($param,0,3) . '-' . substr($param,3,4);
    }
}

if (! function_exists('convertDateBR')) {
    function convertDateBR(?string $param)
    {
        if($param == ''){
            return '';
        }
        return date('d/m/Y', strtotime($param));
    }
}

if (! function_exists('convertDateTimeBR')) {
    function convertDateTimeBR(?string $param)
    {
        if($param == ''){
            return '';
        }
        return date('d/m/Y H:i:s', strtotime($param));
    }
}

if (! function_exists('convertStringToDate')) {
    function convertStringToDate(?string $param)
    {
        if(empty($param)){
            return null;
        }

        list($day, $month, $year) = explode('/', $param);
        try {
            return (new DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
        } catch (Exception $e) {
            return null;
        }
    }
}

if (! function_exists('convertStringToDateTime')) {
    function convertStringToDateTime(?string $param)
    {
        if(empty($param)){
            return null;
        }

        list($day, $month, $yearTime) = explode('/', $param);
        list($year,$time) = explode(' ', $yearTime);
        try {
            return (new DateTime($year . '-' . $month . '-' . $day . ' ' .$time))->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            return null;
        }

        return date('Y-m-d H:i:s', strtotime($param));
    }
}

if (! function_exists('convertDateTimeToDate')) {
    function convertDateTimeToDate(?string $param)
    {
        if(empty($param)){
            return null;
        }

        try {
            return (date('Y-m-d', strtotime($param)));
        } catch (Exception $e) {
            return null;
        }
    }
}

if (! function_exists('convertDoubleToString')) {
    function convertDoubleToString(?float $param)
    {
        return number_format($param, 2, ',', '.');
    }
}

if (! function_exists('convertDoubleToMoneyString')) {
    function convertDoubleToMoneyString(?float $param)
    {
        return 'R$ '.number_format($param, 2, ',', '.');
    }
}

if (! function_exists('convertFirstsUp')) {
    function convertFirstsUp(?string $param)
    {
        $delimiter = ["/","\\","(",")","{","}","[","]",";",":","<",">","/","-","_"];
        $spaceDelimiter = [" / "," \\ "," ( "," ) "," { "," } "," [ "," ] "," ; "," : "," < "," > ","  / "," - "," _ "];

        $dilimiterEspecialChars = [' Pcc','-ii',' ht',' p1',' pc',' pm',' cd',' dvd',' Lcd',' Cnh',' Oab'];
        $chargeEspecialChars = [' PCC','-II',' HT',' P1',' PC',' PM',' CD',' DVD',' LCD',' CNH',' OAB'];

        $wordsSkip = ['das','dos','que','com'];

        $param = mb_strtolower($param,'UTF-8');

        $param = str_replace($delimiter,$spaceDelimiter,$param);

        $words = explode(' ', $param);
        $newWord = "";
        if(count($words) > 1){
            $firstWord = $words[0];
            foreach ($words as $word){
                if($firstWord == $word || (strlen($word) > 2 && !in_array($word,$wordsSkip))){
                    $newWord = $newWord.' '.ucfirst($word);
                }else{
                    $newWord = $newWord.' '.$word;
                }
            }
        }else{
            $newWord = ucfirst($param);
        }
        $newWord = str_replace($spaceDelimiter,$delimiter,$newWord);
        $newWord = str_replace($dilimiterEspecialChars,$chargeEspecialChars,$newWord);

        return trim($newWord);
    }
}

if (! function_exists('getInitials')) {
    function getInitials(?string $param)
    {
        $param = mb_strtoupper($param);
        $words = explode(' ', $param);
        $newWord = "";
        if(count($words) > 1){
            $firstWord = $words[0];
            foreach ($words as $word){
                if($firstWord == $word || strlen($word) > 3){
                    $newWord = $newWord.substr($word,0,1);
                }
            }
        }else{
            $newWord = substr($words,0,1);
        }
        return trim($newWord);
    }
}

if (! function_exists('getDefaultAvatar')) {
    function getDefaultAvatar()
    {
        return url(asset('img/person.png'));
    }
}

if (! function_exists('getDefaultAvatarToPDF')) {
    function getDefaultAvatarToPDF()
    {
        return public_path('img/person.png');
    }
}

if (! function_exists('convertStringUp')) {
    function convertStringUp(?string $param)
    {
        return $param = mb_strtoupper($param);
    }
}

if (! function_exists('showCharacters')) {
    function showCharacters($text = "", int $size = 20)
    {
        if(!empty($text) && strlen($text) > $size){
            return substr($text,0,$size)." ...";
        }

        return $text;
    }
}

if (! function_exists('formatImei')) {
    function formatImei(?string $param)
    {
        return substr($param,0,3) . '.' . substr($param,3,3) . '.' . substr($param,6,3) . '.' . substr($param,9,3) . '.' . substr($param,12,3);
    }
}

if (! function_exists('formatPhone')) {
    function formatPhone(?string $param)
    {
        $lenPhone = strlen($param);
        if($lenPhone == 13){
            return "+".substr($param,0,2) . ' (' . substr($param,2,2) . ') ' . substr($param,4,5) . '-' . substr($param,9,4);
        }else{
            return "+".substr($param,0,2) . ' (' . substr($param,2,2) . ') ' . substr($param,4,4) . '-' . substr($param,8,4);
        }
    }
}

if (! function_exists('getDefaultFile')) {
    function getDefaultFile()
    {
        return url(asset('img/desconhecido.png'));
    }
}


//    <!-- INIT FUNCTION WEEKDAY, RETURN THE DAY OF THE WEEK -->
if (! function_exists('weekDay')) {
    function weekDay(?string $param)
    {
        $ano =  substr("$param", 0, 4);
        $mes =  substr("$param", 5, -3);
        $dia =  substr("$param", 8, 9);

        $weekDay = date("w", mktime(0,0,0,$mes,$dia,$ano) );

        switch($weekDay) {
            case"0": $weekDay = "DOMINGO"; break;
            case"1": $weekDay = "SEGUNDA"; break;
            case"2": $weekDay = "TERÇA";   break;
            case"3": $weekDay = "QUARTA";  break;
            case"4": $weekDay = "QUINTA";  break;
            case"5": $weekDay = "SEXTA";   break;
            case"6": $weekDay = "SÁBADO";  break;
        }

        return $weekDay;
    }
}
//    <!-- FINISH FUNCTION WEEKDAY -->


//    <!-- INIT FUNCTION PERIOD, RETURN THE PERIOD OF THE DAY -->
if (! function_exists('period')) {
    function period(?string$hour)
    {
        $period = (substr($hour, 0, 2));
        if ($period >= 00 && $period < 06) {
            return 'MADRUGADA';
        } else if ($period >= 06 && $period < 12) {
            return 'MANHÃ';
        } else if ($period >= 12 && $period < 18) {
            return 'TARDE';
        } else if ($period >= 18 && $period < 24) {
            return 'NOITE';
        }
    }
}
//    <!-- FINISH FUNCTION PERIOD -->

if (! function_exists('printNotEmpty')) {
    function printNotEmpty($var, $text = "Não Consta")
    {
        return (!empty($var) ? $var : $text);
    }
}
