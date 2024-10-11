<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "maxPonto";
    $port = 3306;

    try{
        $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbName, $user, $password);
    }catch(PDOException $err){
        echo "Erro" . $err->getMessage();
    }

?>