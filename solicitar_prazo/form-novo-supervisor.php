<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1 ){
    $idUsuario = $_SESSION['idUsuario'];

    $sql = $db->query("SELECT * FROM usuarios WHERE idusuarios = '$idUsuario'");
    if($sql->rowCount()>0){
        $dado = $sql->fetch();

        $nomeUsuario = $dado['nome'];
        $tipoUsuario = $dado['idtipo_usuario'];
    }else{
        header("Location:login.php");
    }
}else{
    header("Location:login.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cadastrar Supervisor</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <div class="container-fluid">
            <div class="cabecalho">
                <a href="index.php"><img src="assets/images/logo.png" alt=""></a> 
                <div class="titulo">Basto Mesquita Dist e Logistica</div>
            </div>
            <div class="menu">
                <img class="menu-mobile" src="assets/images/menu.png" alt="" onclick="abrirMenu()">
                <nav id="menuMobile">
                    <ul class="nav flex-column">
                        <li class="nav-item"> <a class="nav-link" href="index.php">Início</a> </li>
                        <li class="nav-item"> <a class="nav-link" href='sair.php'>Sair</a> </li>
                    </ul>
                </nav>
            </div>

            <form action="add-novo-supervisor.php" method="post">
                <div class="centralizar-form ">
                    <div class="form-group col-md-3 espaco">
                        <label for="nome">Nome</label>
                        <input required type="text" name="nome" id="nome" class="form-control">
                    </div>
                    <div class="form-group col-md-3 espaco ">
                        <label for="email">E-mail</label>
                        <input required type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="senha">Senha</label>
                        <input required type="password" name="senha" id="senha" class="form-control">
                    </div>
                    <button type="submit" name="add=-supervisor" class="btn btn-primary"> Cadastrar </button>
                </div>
                
            </form>
        </div>

        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/js/jquery.mask.js"></script>
    </body>
</html>