<?php

session_start();
if (!isset($_SESSION['esta_logado']) OR !$_SESSION['esta_logado'] == true){

    //usuario nao logado
    header('Location: login.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>
<body>

<div class="social">

    <a href="verifica_usuario.php?acao=sair" class="sair">sair</a>
    <a href="index.phtml?acao=sair" class="sair">sair</a>


    <img src="https://images.minilua.com/wp-content/uploads/2012/04/homer-simpson-32_thumb.jpg" alt="" width="200" height="200">
    <h3>Bem vindo!</h3>
</div>

</body>
</html>