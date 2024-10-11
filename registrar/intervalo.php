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

$sql_ponto = "SELECT * FROM ponto WHERE usuarioFk = :usuarioId ORDER BY pontoId DESC LIMIT 1";

$result_ponto = $conn->prepare($sql_ponto);

$result_ponto->bindParam(':usuarioId', $_SESSION["usuarioId"]);

$result_ponto->execute();


if(($result_ponto) and ($result_ponto->rowCount() != 0)){
    $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);
   
    // Entrada do intervalo
    if(($row_ponto["entrada"] != "" or $row_ponto["entrada"] != null) and ($row_ponto["saida"] == "" or $row_ponto["saida"] == null) and ($row_ponto["inicioIntervalo"] == "" or $row_ponto["inicioIntervalo"] == null)){
        
        $sql_entradaIntervalo = "UPDATE ponto SET inicioIntervalo = :hora WHERE pontoId = :idPonto";

        $result_entradaIntervalo = $conn->prepare($sql_entradaIntervalo);

        $result_entradaIntervalo->bindParam(':idPonto', $row_ponto["pontoId"]);
        $result_entradaIntervalo->bindParam(':hora', $hora);

        $result_entradaIntervalo->execute();

        // Indicar que o cara está ou não, trabalhando
        $sql_indicarTrabalhando = "UPDATE usuario SET trabalhando = 0, intervalo = 1 WHERE usuarioId = :idUser";
        $result_indicarTrabalhando = $conn->prepare($sql_indicarTrabalhando);
        $result_indicarTrabalhando->bindParam(':idUser', $usuarioId);
        $result_indicarTrabalhando->execute();

        $_SESSION["msgPonto"] = "Entrada de intervalo Registrado com sucesso!!";
        
        header("location: ../index/index.php");  
    }elseif(($row_ponto["entrada"] != "" or $row_ponto["entrada"] != null) and ($row_ponto["saida"] == "" or $row_ponto["saida"] == null) and ($row_ponto["inicioIntervalo"] != "" or $row_ponto["inicioIntervalo"] != null)){
        
        $sql_saidaIntervalo = "UPDATE ponto SET fimIntervalo = :hora WHERE pontoId = :idPonto";

        $result_saidaIntervalo = $conn->prepare($sql_saidaIntervalo);

        $result_saidaIntervalo->bindParam(':idPonto', $row_ponto["pontoId"]);
        $result_saidaIntervalo->bindParam(':hora', $hora);

        $result_saidaIntervalo->execute();

        // Indicar que o cara está ou não, trabalhando
        $sql_indicarTrabalhando = "UPDATE usuario SET trabalhando = 1, intervalo = 0 WHERE usuarioId = :idUser";
        $result_indicarTrabalhando = $conn->prepare($sql_indicarTrabalhando);
        $result_indicarTrabalhando->bindParam(':idUser', $usuarioId);
        $result_indicarTrabalhando->execute();

        $_SESSION["msgPonto"] = "Saida do intervalo Registrado com sucesso!!";
        
        header("location: ../index/index.php");  
    }
}else{
    header("location: entrada.php");
}