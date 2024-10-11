<?php
session_start();
include_once "../conexao/conexao.php";

$id = $_POST["usuario"];
$senha = $_POST["senha"];

// Query para pesquisar o usuário de acordo com o ID e senha
$sql_logar = "SELECT * FROM usuario WHERE usuarioId = :usuarioId AND senha = :senha";

// Variavel para conexão com BD
$result_logar = $conn->prepare($sql_logar);

// Setando os dados do fomrulario na qury
$result_logar->bindParam(':usuarioId', $id);
$result_logar->bindParam(':senha', $senha);

// Execução da Query
$result_logar->execute();

if(($result_logar) and ($result_logar->rowCount() != 0)){
    // Variavel para coletar o resultado
    $row_logar = $result_logar->fetch(PDO::FETCH_ASSOC);

    $_SESSION["nome"] = $row_logar["nome"];
    $_SESSION["usuarioId"] = $row_logar["usuarioId"];
    $_SESSION["logado"] = 1;
    $_SESSION["permissao"] = $row_logar["permissao"];
    header("Location: ../index/index.php");
 
}else{
    $_SESSION["msgErro"] = ".  Erro ao logar! Usuário ou Senha incorretos.";
    header("location: login.php");
}
