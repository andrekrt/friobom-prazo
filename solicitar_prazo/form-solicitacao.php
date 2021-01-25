<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false ){
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
        <title>Nova Solicitação</title>
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
                        
                        <?php
                                
                        ?>
                        <li class="nav-item"> <a class="nav-link" href='sair.php'>Sair</a> </li>
                    </ul>
                </nav>
            </div>

            <form action="add-solicitacao.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-3 espaco">
                        <label for="cod_cliente">Código Cliente</label>
                        <input type="text" required name="cod_cliente" class="form-control" id="cod_cliente">
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="nome_cliente">Nome Cliente</label>
                        <input type="text" required name="nome_cliente" class="form-control" id="nome_cliente">
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="fone">Telefone</label>
                        <input type="text" name="fone" class="form-control" id="fone">
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="fone2">Telefone 2</label>
                        <input type="text" name="fone2" class="form-control" id="fone2">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 espaco">
                        <label for="prazo">Prazo(Em Dias)</label>
                        <input type="text" name="prazo" class="form-control" id="prazo">
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="rca">RCA</label>
                        <input type="text" required name="rca" class="form-control" id="rca">
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="firma_no_nome">Firma no Nome do Titular?</label>
                        <select class="form-control" name="firma_no_nome" id="firma_no_nome">
                            <option value=""></option>
                            <option value="SIM">SIM</option>
                            <option value="NÃO">NÃO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 espaco">
                        <label for="predio">Prédio Próprio?</label>
                        <select class="form-control" name="predio" id="predio">
                            <option value=""></option>
                            <option value="SIM">SIM</option>
                            <option value="NÃO">NÃO</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 espaco">
                        <label for="obs">Observação</label>
                        <input type="text" name="obs" class="form-control" id="obs">
                    </div>
                    <div class="form-group col-md-6 espaco">
                        <label for="anexo" >Inserir Arquivos</label>
                        <input type="file" name="anexos[]" multiple="multiple" id="anexo" class="form-control-file">
                    </div>
                </div>

                <button type="submit" name="add-solicitacao" class="btn btn-primary"> Enviar Solicitação</button>
            </form> 

        </div>

        

        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/js/jquery.mask.js"></script>
        <script>
            $(document).ready(function(){
                $('#fone').mask('(99) 99999-9999');
                $('#fone2').mask('(99) 99999-9999');
            });
        </script>
    </body>
</html>