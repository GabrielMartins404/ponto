<?php

session_start(); //Todos os campos que necessitam de um sessão, precisa ativar
session_unset(); //Apaga os dados da sessá0
session_destroy(); //Destroi a sessão
header("location: login.php");