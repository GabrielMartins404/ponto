<?php
 date_default_timezone_set("America/Sao_paulo");    
    function diferencaHora( $entradaPT, $saidaPT, $inicioIntervalo, $fimIntervalo){
        date_default_timezone_set("America/Sao_paulo");
        $horaAtual = date("H:i:s");

        $entrada = DateTime::createFromFormat('H:i:s', $entradaPT);
        $saida = $saidaPT != NULL ? DateTime::createFromFormat('H:i:s', $saidaPT) : DateTime::createFromFormat('H:i:s', $horaAtual);


        $total = $entrada->diff($saida);
        $total = $total->format('%H:%I:%S');

        $final = $total;

        $inicioIntervalo = DateTime::createFromFormat('H:i:s',  $inicioIntervalo);
        $fimIntervalo = DateTime::createFromFormat('H:i:s',$fimIntervalo);

        $resultado = [];

        if($inicioIntervalo !=null and $fimIntervalo != null){
            
            $intervalo = $inicioIntervalo->diff($fimIntervalo);
            $intervalo = $intervalo->format('%H:%I:%S');

            $horasTotais = DateTime::createFromFormat('H:i:s',  $total);
            $horasIntervalo = DateTime::createFromFormat('H:i:s',  $intervalo);

            $final = $horasTotais->diff($horasIntervalo);
            $final = $final->format('%H:%I:%S');

            $resultado["intervalo"] = $intervalo;
        }
        $resultado["final"] = $final;
        return $resultado;
    }

    function somarHoras($horasDados , $sinal){
        $soma = 0;

        
        foreach ($horasDados as $horaItem) {
            $calc = 0;
            list($horas, $minutos, $segundos) = explode(':', $horaItem);
            $calc = $horas * 3600 + $minutos * 60 + $segundos;
            
            if($sinal == "-"){
                $soma -= $calc;
            }else{
                $soma += $calc;
            }
            
        }

        if($soma < 0){
            $soma *= -1;
        }
        $hours = floor($soma / 3600);
        $minutes = floor($soma % 3600 / 60);
        $seconds = floor($soma % 60);
        
        if($sinal == "-"){
            // return "-" . sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
            return [sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds), "-"];
        }else{
            return [sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds), "+"];
        }
    }  

    function subtrairHoras($positivo , $negativo){
        $sinal = "+";
        $soma = 0;

        if(gettype($positivo) != "integer" AND gettype($negativo) != "integer"){
            list($horasNegativas, $minutosNegativas, $segundosNegativos) = explode(':', $negativo);
            $segNegativos = $horasNegativas * 3600 + $minutosNegativas * 60 + $segundosNegativos;

            list($horasPositivas, $minutosPositivas, $segundosPositivos) = explode(':', $positivo);
            $segPositivos = $horasPositivas * 3600 + $minutosPositivas * 60 + $segundosPositivos;

        }else{
            $segNegativos = $negativo;
            $segPositivos = $positivo;
        }
           
        if($segNegativos >= $segPositivos){
            $soma = $segNegativos - $segPositivos;
            $sinal = "-";
        }else{
            $soma = $segPositivos - $segNegativos;
            $sinal = "+";
        }

        $hours = floor($soma / 3600);
        $minutes = floor($soma % 3600 / 60);
        $seconds = floor($soma % 60);
        
        if($sinal == "-"){
            return [sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds), "-"];
        }else{
            return [sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds), "+"];
        }
    }  

    function horaExtraSegundos($totalSegundos){
        $sinal = "";
        $segundosPadrao = 28800;
    
        if($totalSegundos >= $segundosPadrao){
            $sinal = "+";
        }else{
            $sinal = "-";
        }

        $horasExtras = $segundosPadrao - settype($totalSegundos, "integer");

        $resultado = [$horasExtras, $sinal];
        return $resultado;   
    }
    function horaExtra($final){
        $sinal = "";
        $segundosPadrao = 28800;
        $horasTrabalhadas = $final;

        list($horas, $minutos, $segundos) = explode(':', $horasTrabalhadas);
        $segundosTrabalhados = $horas * 3600 + $minutos * 60 + $segundos;

        if($segundosTrabalhados >= $segundosPadrao){
            $sinal = "+";
        }else{
            $sinal = "-";
        }
        
        $horaPadrao = DateTime::createFromFormat('H:i:s',  "08:00:00");
        $horasTrabalho = DateTime::createFromFormat('H:i:s',  $horasTrabalhadas);

        $extra = $horaPadrao->diff($horasTrabalho);
        $horasExtras = $extra->format('%H:%I:%S');

        $resultado = [$horasExtras, $sinal];
        return $resultado;   
    }


    // Função responsável por cálcular os segundo trabalhados pelo infeliz
    function segundos($horasDiferenca){
        // var_dump($horasDiferenca);
        if(isset($horasDiferenca)){
            list($horas, $minutos, $segundos) = explode(':', $horasDiferenca["final"]);
            $calc = $horas * 3600 + $minutos * 60 + $segundos;
            return $calc;
        }
    }



    // Função responsável por separar e juntas os segundos com base nos usuários e dias