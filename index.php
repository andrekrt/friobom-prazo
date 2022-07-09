<?php

if(isset($_POST['btn-sistema']) && !empty($_POST['sistema'])){
    $sistema = filter_input(INPUT_POST, 'sistema');

    switch ($sistema) {
        case '1':
            header("location: https://logistica.friobomnegociacoes.com/");
            break;
        case '2':
            header("location: https://documentacao.friobomnegociacoes.com/");
            break;
        case '3':
            header("location: https://friobomnegociacoes.com/solicitar_prazo/index.php");
            break;
        case '4':
            header("location: http://192.168.10.32/portaria/");
            break;
        case '5':
            header("location: http://192.168.10.32/merchan/");
            break;
        case '6':
            header("location: http://192.168.10.32/trocas/");
            break;
        default:
            # code...
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FRIOBOM - SISTEMAS</title>
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
        <div class="logo">
            <img src="assets/images/LOGO-red.png" alt="">
        </div>
        <div class="titulo">
            <h3>acesse o sistema desejado abaixo:</h3>
        </div>
        <div class="opcao">
            <form action="" method="POST">
                <select required name="sistema" id="sistema" class="form-control">
                    <option value=""></option>
                    <option value="1">Logística</option>
                    <option value="2">RH</option>
                    <option value="3">Solicitação de Prazo</option>
                    <option value="4">Portaria</option>
                    <option value="5">Merchandesing</option>
                    <option value="6">Trocas</option>
                </select>
                <button class="btn btn-danger" name="btn-sistema">ACESSAR</button>
            </form>
        </div>
    </div>

    <script src=""></script>
</body>
</html>