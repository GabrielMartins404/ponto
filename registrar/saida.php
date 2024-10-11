<?php

session_start();

date_default_timezone_set("America/Sao_paulo");

if(!isset($_SESSION["logado"]) or $_SESSION["logado"] != 1){
    header("location: ../login/login.php");
}

$data = date("Y/m/d");
$hora = date("H:i:s");

$usuarioId = $_SESSION["usuarioId"];

include_once "../conexao/conexao.php";
include "../includes/funcoes.php";

$sql_ponto = "SELECT * FROM ponto WHERE usuarioFk = :usuarioId ORDER BY pontoId DESC LIMIT 1";

$result_ponto = $conn->prepare($sql_ponto);

$result_ponto->bindParam(':usuarioId', $_SESSION["usuarioId"]);

$result_ponto->execute();

if(($result_ponto) and ($result_ponto->rowCount() != 0)){
    $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);

    if(($row_ponto["entrada"] != "" or $row_ponto["entrada"] != null) and ($row_ponto["saida"] == "" or $row_ponto["saida"] == null)){
        $sql_pontoSaida = "UPDATE ponto SET saida = :hora WHERE pontoId = :idPonto";

        $result_pontoSaida = $conn->prepare($sql_pontoSaida);

        $result_pontoSaida->bindParam(':idPonto', $row_ponto["pontoId"]);
        $result_pontoSaida->bindParam(':hora', $hora);

        $result_pontoSaida->execute();

        // Indicar que o cara não está mais trabalhando
        $sql_indicarTrabalhando = "UPDATE usuario SET trabalhando = 0, intervalo = 0 WHERE usuarioId = :idUser";

        $result_indicarTrabalhando = $conn->prepare($sql_indicarTrabalhando);
        $result_indicarTrabalhando->bindParam(':idUser', $usuarioId);
        $result_indicarTrabalhando->execute();

        // Parte para setar a hora  e segundos do ponto
        $diferenca = diferencaHora($row_ponto["entrada"], $row_ponto["saida"], $row_ponto["inicioIntervalo"], $row_ponto["fimIntervalo"]);
        $final = $diferenca["final"];

        // Variavel que chama a função que ler os segundos
        $segundos = segundos($diferenca);
        $horasExtras = horaExtra($final);

        $sql_horaExtra = "UPDATE ponto SET horaExtra = :hora, horaExtraSinal = :sinal, segundosPonto = :segundos WHERE pontoId = :idPonto";

        $result_horaExtras = $conn->prepare($sql_horaExtra);

        $result_horaExtras->bindParam(':idPonto', $row_ponto["pontoId"]);
        $result_horaExtras->bindParam(':hora', $horasExtras[0]);
        $result_horaExtras->bindParam(':sinal', $horasExtras[1]);
        $result_horaExtras->bindParam(':segundos', $segundos);
        $result_horaExtras->execute();

        header("location: ../index/index.php"); 
    }else{
        // Indicar que o cara não está mais trabalhando
        $sql_indicarTrabalhando = "UPDATE usuario SET trabalhando = 0, intervalo = 0 WHERE usuarioId = :idUser";
        $result_indicarTrabalhando = $conn->prepare($sql_indicarTrabalhando);
        $result_indicarTrabalhando->bindParam(':idUser', $usuarioId);
        $result_indicarTrabalhando->execute();

        $_SESSION["msgPonto"] = "Expediente finalizado com sucesso!!";
        header("location: ../index/index.php"); 
    }
}