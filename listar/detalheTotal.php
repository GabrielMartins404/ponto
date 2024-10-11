<?php
    session_start();
    ob_start();
    
    date_default_timezone_set("America/Sao_paulo");

    if(!isset($_SESSION["logado"]) or $_SESSION["logado"] != 1){
        header("location: ../login/login.php");
    }
    
    $data = date("Y-m-d");
    $hora = date("H:i:s'");
    $id = $_GET["id"];

    include_once "../conexao/conexao.php";
    include_once "../includes/funcoes.php";

    $sql_usuario = "SELECT * FROM usuario WHERE usuarioId = :idUser";   
    $result_usuario = $conn->prepare($sql_usuario);
    $result_usuario->bindParam(':idUser', $id);
    $result_usuario->execute();

    if($result_usuario->rowCount() == 0){
        header("location: listaTotais.php");
    }
    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

    $sql_ponto = "SELECT * FROM ponto WHERE usuarioFk = :idUser";

    if(isset($_POST["buscar"])){
        $dataInicio = $_POST["dataInicio"];
        $dataFim = $_POST["dataFim"];

        if(strtotime($dataInicio) > strtotime($dataFim) or $dataFim == ""){
            $dataFim = $data;
        }

        $sql_ponto = "SELECT * FROM ponto WHERE usuarioFk = :idUser AND dataPonto BETWEEN '".$dataInicio ."' and '".$dataFim."'";
    }

    $result_ponto = $conn->prepare($sql_ponto);
    $result_ponto->bindParam(':idUser', $id);
    $result_ponto->execute();
    $row_ponto = $result_ponto->fetchAll(PDO::FETCH_ASSOC);

    $horasTrabalhadas = [];
    $horasIntervalo = [];
    $horasExtras = [];
    $cacheDias = [];
  

    // Parte para agrupar as  horas extras
    $positivas = ["00:00:00"];
    $negativas = ["00:00:00"];

    foreach ($row_ponto as $res) {
        $resHoras = diferencaHora($res["entrada"], $res["saida"], $res["inicioIntervalo"], $res["fimIntervalo"]);
        $horasTrabalhadas[] = isset($resHoras["final"]) ? $resHoras["final"] : "00:00:00";
        $horasIntervalo[] = isset($resHoras["intervalo"]) ? $resHoras["intervalo"] : "00:00:00";

        if($res["horaExtra"] != null){
            if($res["horaExtraSinal"] == "+"){
                array_push($positivas, $res["horaExtra"]);
            }else{
                array_push($negativas, $res["horaExtra"]);
            }
        }
        array_push( $cacheDias, $res["dataPonto"]);
    }

    // Parte dos dias trabalhados
    $cacheDias = array_unique($cacheDias);
    $diasTrabalhados = count($cacheDias);
    // Parte que soma as horas trabalhadas e de intervalo
    $horasTrabalhadasTotais = somarHoras($horasTrabalhadas, "+")[0];
    $horasIntervaloTotal = somarHoras($horasIntervalo, "+")[0];

    // Parte para somar as horas extras
    $horasTotaisNegativas = somarHoras($negativas, "-")[0];
    $horasTotaisPositivas = somarHoras($positivas, "+")[0];

    $totalHoraExtra = subtrairHoras($horasTotaisPositivas, $horasTotaisNegativas);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->

    <link rel="stylesheet" href="../css/acompanhar.css">
    <link rel="stylesheet" href="../css/miriam.css">
    <title>Sistema de Pontos</title>

</head>
<body>
    <?php
        include_once "../includes/navBar.php";
    ?>
    <div class="container">
        <div class="container-bg">
            <form action="" method="post">
                <div class="filtro filtro-container">
                    <div class="filtro ">
                        <label for="data">Data Inicio</label>
                        <input type="date" class="form-control" id="dataInicio" name = "dataInicio">
                    </div>
                    <div class="filtro">
                        <label for="data">Data Fim</label>
                        <input type="date" class="form-control" id="dataFim" name = "dataFim">
                    </div>

                    <button type = "submit" name = "buscar" class="btn btn-padrao">Buscar</button>
                </div>
            </form>


            <?php 
                if($row_usuario != ""){
            ?>            
                <h1><?php echo $row_usuario["nome"]?></h1>
                <p>Total de horas trabalhadas no período: <?php echo $horasTrabalhadasTotais != "00:00:00" ? $horasTrabalhadasTotais : "Sem registro"?></p>
                <p>Total de horas de intervalo no período: <?php echo $horasIntervaloTotal != "00:00:00" ? $horasIntervaloTotal : "Sem registro"?></p>
                <p>Total de dias trabalhados no período: <?php echo $diasTrabalhados ?></p>
                <p>Total de horas extras trabalhadas no período: <?php echo $totalHoraExtra != "00:00:00" ? $totalHoraExtra[1] . " " .$totalHoraExtra[0] : "Sem registro :("?></p>
            <?php
                }else{
            ?>
                <h1>Sem nada para apresentar :)</h1>
            <?php
                }
            ?>
        </div>
    </div>
    

</body>
</html>