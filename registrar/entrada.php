<?php

session_start();

date_default_timezone_set("America/Sao_paulo");

if(!isset($_SESSION["logado"]) or $_SESSION["logado"] != 1){
    header("location: ../login/login.php");
}


$data = date("Y/m/d");
$hora = date("H:i:s'");

$usuarioId = $_SESSION["usuarioId"];

include_once "../conexao/conexao.php";

$sql_ponto = "SELECT * FROM ponto WHERE usuarioFk = :usuarioId ORDER BY pontoId DESC LIMIT 1";

$result_ponto = $conn->prepare($sql_ponto);

$result_ponto->bindParam(':usuarioId', $_SESSION["usuarioId"]);

$result_ponto->execute();

if(($result_ponto) and ($result_ponto->rowCount() != 0)){
    $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);

    if(($row_ponto["entrada"] != "" OR $row_ponto["entrada"] != null) and ($row_ponto["saida"] != "" OR $row_ponto["saida"] != null)){
        inserirPonto($conn, $usuarioId, $data, $hora);    
    }
}else{
    inserirPonto($conn, $usuarioId, $data, $hora);
    
}

function inserirPonto($conn, $usuarioId, $data, $hora){
    $sql_pontoEntrada = "INSERT INTO ponto (usuarioFk, entrada, dataPonto) VALUES ( :idUser, :hora, :dia)";

    $result_pontoEntrada = $conn->prepare($sql_pontoEntrada);

    $result_pontoEntrada->bindParam(':idUser', $usuarioId);
    $result_pontoEntrada->bindParam(':dia', $data);
    $result_pontoEntrada->bindParam(':hora', $hora);

    $result_pontoEntrada->execute();

    // Parte para controlar se ele está trabalhando ou não
    $sql_indicarTrabalhando = "UPDATE usuario SET trabalhando = 1, intervalo = 0 WHERE usuarioId = :idUser";

    $result_indicarTrabalhando = $conn->prepare($sql_indicarTrabalhando);

    $result_indicarTrabalhando->bindParam(':idUser', $usuarioId);

    $result_indicarTrabalhando->execute();
    $_SESSION["msgPonto"] = "Ponto Registrado com sucesso!!";
    header("location: ../index/index.php");  
}


