<?php
session_start();
include_once "../conexao/conexao.php";

      if (isset($_POST['ENVIAR arquivo']));
      $formatos_permitidos = array("png", "jpeg", "jpg", "gif");
      $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

      if (in_array($extensao, $formatos_permitidos)) {
            echo "existe";
      } else {
            echo "nao existe";
      }
?>

<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
</head>

<body>
      <h1> enviar arquivo </h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            arquivo <input type="file" required name="arquivo">
            <input type="submit" value="ENVIAR arquivo">
      </form>
</body>

</html>