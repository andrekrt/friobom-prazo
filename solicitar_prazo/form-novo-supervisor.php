<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1 ){
    $idUsuario = $_SESSION['idUsuario'];

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
        <title>Friobom - Prazos</title>
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
        <div class="container-fluid corpo">
            <div class="menu-lateral" id="menu-lateral">
                <div class="logo">
                    <img src="assets/images/logo-red.png" >
                </div>
                <div class="opcoes">
                    <div class="item">
                        <a class="nav-link" href="index.php"> <img src="assets/images/inicio.png"> </a>
                    </div>
                    <div class="item">
                        <a class="nav-link" href="gerar-planilha.php"> <img src="assets/images/planilha.png"> </a>
                    </div>
                    <div class="item">
                        <a class="nav-link" href="form-novo-supervisor.php"> <img src="assets/images/novo-supervisor.png"> </a> 
                    </div>
                    <div class="item">
                        <a class="nav-link" href="supervisores.php"> <img src="assets/images/supervisores.png" ></a> 
                    </div>
                    <div class="item">
                        <a href="sair.php"> <img src="assets/images/sair.png"> </a>
                    </div>
                </div>
            </div>
            <div class="tela-principal">
                <div class="menu-superior">
                    <div class="icone-menu-superior">
                        <img src="assets/images/icone-novo-supervisor.png" alt="">
                    </div>
                    <div class="title">
                        <h2>Novo Supervisor</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="assets/images/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <div class="menu-principal">
                    <form action="add-novo-supervisor.php" method="post">
                        <div class="form-group col-md-12 espaco">
                            <label for="nome">Nome</label>
                            <input required type="text" name="nome" id="nome" class="form-control">
                        </div>
                        <div class="form-group col-md-12 espaco ">
                            <label for="email">E-mail</label>
                            <input required type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group col-md-12 espaco">
                            <label for="senha">Senha</label>
                            <input required type="password" name="senha" id="senha" class="form-control">
                        </div>
                        <button type="submit" name="add=-supervisor" class="btn btn-primary"> Cadastrar </button>
                    </form>
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/js/jquery.mask.js"></script>
        <script src="assets/js/menu.js"></script>
    </body>
</html>