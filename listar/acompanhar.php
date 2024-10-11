<?php
    session_start();
    ob_start();
    
    date_default_timezone_set("America/Sao_paulo");
    
    if(isset($_SESSION["logado"])){
        $nome = $_SESSION["nome"];
    }else{
        header('location: ../login/login.php');
    };

    include_once "../conexao/conexao.php";
    include "../includes/funcoes.php";

    // Comando para verificar se o usuario está trabalhando
    $sql_usuario = "SELECT * FROM usuario";
    $result_usuario = $conn->prepare($sql_usuario);
    $result_usuario->execute();
    $row_usuarios = $result_usuario->fetchAll(PDO::FETCH_ASSOC);

    // Comando para verificar se o usuario está no de descanso
    $sql_ponto = "SELECT inicioIntervalo, fimIntervalo FROM ponto WHERE usuarioFk = :usuarioId ORDER BY pontoId DESC LIMIT 1";
    $result_ponto = $conn->prepare($sql_ponto);
    $result_ponto->bindParam(':usuarioId', $_SESSION["usuarioId"]);
    $result_ponto->execute();
    $row_ponto = $result_ponto->fetch(PDO::FETCH_ASSOC);

    if(isset($_SESSION["resultado"])){
        $resultados = $_SESSION["resultado"];
    }else{
        header('location: filtrar.php');
    }
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
        <form action="filtrar.php" method="post" id = "form_buscar">
            <div class="filtro filtro-container">
                <select class="form-select" name = "usuario" aria-label="Default select example">
                    <option value = "" selected>Selecione um usuário</option>
                    <?php
                        foreach ($row_usuarios as $usuario) {
                    ?>
                    <option value = <?php echo $usuario["usuarioId"]?>><?php echo $usuario["nome"]?></option>
                    <?php
                        }
                    ?>
                </select>

                <div class="filtro">
                    <label for="data">Data Inicio</label>
                    <input type="date" class="form-control" id="dataInicio" name = "dataInicio">
                </div>

                <div class="filtro">
                    <label for="data">Data Fim</label>
                    <input type="date" class="form-control" id="dataFim" name = "dataFim">
                </div>

                <button type = "submit" name = "buscar" class="btn btn-padrao" id = "btn_buscar">Buscar</button>
            </div>
        </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Data</th>
                <th scope="col">Horario de entrada</th>
                <th scope="col">Inicio Intervalo</th>
                <th scope="col">Fim do Intervalo</th>
                <th scope="col">Total de intervalo</th>
                <th scope="col">Horario de saida</th>
                <th scope="col">Total de horas Trabalhada no dia</th>
                <th scope="col">Horas Extras</th>
            </tr>
        </thead>
        <tbody>
            <?php

                $users = [];
                array_push($users, $resultados[0]["usuarioFk"]);

                foreach ($resultados as $res) {
                    
                    $diferenca = diferencaHora($res["entrada"], $res["saida"], $res["inicioIntervalo"], $res["fimIntervalo"]);
                    $data = new DateTimeImmutable($res["dataPonto"]);
                    $data = $data->format('d/m/Y');
                    $horaExtra = subtrairHoras($res["somaSegundo"], 28800);
                                     
                ?>
                <tr>
                    <th scope="row"><?php echo $res["nome"]?></th>
                    <td><?php echo $data?></td>
                    <td><?php echo $res["minEntrada"]?></td>
                    <td><?php echo isset($res["minInter"]) ? $res["minInter"] : "Sem registro"?></td>
                    <td><?php echo isset($res["maxFimInter"]) ? $res["maxFimInter"] : "Sem registro"?></td>
                    <td><?php echo isset($diferenca["intervalo"]) ? $diferenca["intervalo"]:"Sem intervalo"?></td>
                    <td><?php echo $res["maxSaida"] != null ? $res["maxSaida"] : "Ponto em aberto"?></td>
                    <td><?php echo ($diferenca["final"] != NULL) ?  $diferenca["final"]:"Ponto em aberto"?></td>
                    <td><?php echo ($horaExtra != NULL) ?  $horaExtra[1] . $horaExtra[0]:"Ponto em aberto"?></td>
                    
                </tr>
                <?php
                 
                    // if(!in_array($res["usuarioFk"], $users)){
                    //     echo"<tr>";
                    //     echo "teste";
                    //     echo"</tr>";
                    //     }
                    // array_push($users, $res["usuarioFk"]);

                }

                ?>

        </tbody>
    </table>

    

    <h1>Acompanhar Totais</h1>
    <?php foreach ($row_usuarios as $res) {
    ?>
        <a href="detalheTotal.php?id=<?php echo $res["usuarioId"]?>">
            <p scope="row"><?php echo $res["nome"]?></p>
        </a>
    <?php
    }?>
</div>
</div>

    <!-- <script>
        window.onload = function(){
            document.getElementById("Form_buscar").submit();
        }
    </script> -->
</body>
</html>