<?php

session_start();

date_default_timezone_set("America/Sao_paulo");

if(!isset($_SESSION["logado"]) or $_SESSION["logado"] != 1){
    header("location: ../login/login.php");
}

$data = date("Y-m-d");
$hora = date("H:i:s'");
$usuarioId = $_SESSION["usuarioId"];

$dataInicio = $_POST["dataInicio"];
$dataFim = $_POST["dataFim"];
$usuarioFiltro = $_POST["usuario"];

if(strtotime($dataInicio) > strtotime($dataFim) or $dataFim == ""){
    $dataFim = $data;
}

include_once "../conexao/conexao.php";


if((empty($_POST["usuario"]) and $dataInicio == "") or !isset($_POST["usuario"])){
    $sql = "SELECT usuarioFk, dataPonto, SUM(segundosPonto) AS somaSegundo, entrada, saida, inicioIntervalo, fimIntervalo, horaExtra, horaExtraSinal, usuario.nome AS nome, MIN(entrada) AS minEntrada, MIN(inicioIntervalo) AS minInter, max(saida) AS maxSaida, MAX(fimIntervalo) AS maxFimInter FROM ponto INNER JOIN usuario ON usuarioId = usuarioFk GROUP BY usuarioFk, dataPonto ORDER BY usuarioFk";   
}elseif(empty($_POST["usuario"]) and $dataInicio != ""){
    $sql = "SELECT usuarioFk, dataPonto, SUM(segundosPonto) AS somaSegundo, entrada, saida, inicioIntervalo, fimIntervalo, horaExtra, horaExtraSinal, usuario.nome AS nome, MIN(entrada) AS minEntrada, MIN(inicioIntervalo) AS minInter, max(saida) AS maxSaida, MAX(fimIntervalo) AS maxFimInter FROM ponto INNER JOIN usuario ON usuarioId = usuarioFk WHERE dataPonto BETWEEN '".$dataInicio ."' and '".$dataFim."' GROUP BY usuarioFk, dataPonto ORDER BY usuarioFk";
}elseif(!empty($_POST["usuario"]) and $dataInicio == ""){
    $sql = "SELECT usuarioFk, dataPonto, SUM(segundosPonto) AS somaSegundo, entrada, saida, inicioIntervalo, fimIntervalo, horaExtra, horaExtraSinal, usuario.nome AS nome, MIN(entrada) AS minEntrada, MIN(inicioIntervalo) AS minInter, max(saida) AS maxSaida, MAX(fimIntervalo) AS maxFimInter FROM ponto INNER JOIN usuario ON usuarioId = usuarioFk WHERE usuarioFk =".$usuarioFiltro."  GROUP BY usuarioFk, dataPonto ORDER BY usuarioFk";
}elseif(!empty($_POST["usuario"]) and $dataInicio != ""){
    $sql = "SELECT usuarioFk, dataPonto, SUM(segundosPonto) AS somaSegundo, entrada, saida, inicioIntervalo, fimIntervalo, horaExtra, horaExtraSinal, usuario.nome AS nome, MIN(entrada) AS minEntrada, MIN(inicioIntervalo) AS minInter, max(saida) AS maxSaida, MAX(fimIntervalo) AS maxFimInter FROM ponto INNER JOIN usuario ON usuarioId = usuarioFk  WHERE usuarioFk = ".$usuarioFiltro ." and dataPonto BETWEEN '".$dataInicio ."' and '".$dataFim."'  GROUP BY usuarioFk, dataPonto ORDER BY usuarioFk";
}else{
}

$result_filtro = $conn->prepare($sql);
$result_filtro->execute();
$row_filtro = $result_filtro->fetchAll(PDO::FETCH_ASSOC);
$_SESSION["resultado"] = $row_filtro;

header("location: acompanhar.php");

