<?php

session_start();
require("conexao.php");
$erro="";


if(isset($_POST['email']) && empty($_POST['email'])==false){
    $email = filter_input(INPUT_POST, 'email');
    $senha = md5(filter_input(INPUT_POST, 'senha'));

    $sql = $db->query("SELECT * FROM usuarios WHERE email ='$email' AND senha = '$senha' ");

        if($sql->rowCount() > 0 ){
            $dado = $sql->fetch();

            $_SESSION['idUsuario'] = $dado['idusuarios'];
            $_SESSION['tipoUsuario'] = $dado['idtipo_usuario'] ;
            header("Location:index.php");

        }else{
            $erro = "<div class='alert alert-danger' role='alert'>
                        E-mail ou senha incorreto!
                    </div>";
        }
   
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Seja Bem-Vindo</title>
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
    <body >
        <div class="container-fluid login">
            <div class="area-title-login">
                <img src="assets/images/logo.png" alt="">
            </div>
            <div class="area-login">
                <div class="cabecalho">
                    <img src="assets/images/login.png" class="img-fluid" alt="">
                    <p>Entre com seu Login e Senha</p>
                </div>
                <form action="" method="post">
                    <div class="form-grupo espaco">
                        <label for="login">E-MAIL:</label>
                        <input type="email" required name="email" class="form-control" id="login">
                    </div>
                    <div class="form-grupo espaco">
                        <label for="senha">SENHA:</label>
                        <input type="password" required name="senha" class="form-control" id="senha">
                    </div>
                    <button type="submit" class="btn btn-primary"> Entrar</button> <br><br>
                    <p class="erro"> <?php echo $erro;  ?> </p> </p>
                </form>
            </div>
        </div>
        

        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>