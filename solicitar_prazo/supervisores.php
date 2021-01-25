<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario']==1){
    $idUsuario = $_SESSION[ 'idUsuario'];

    $sql = $db->query("SELECT * FROM usuarios WHERE idusuarios = '$idUsuario'");

    if($sql->rowCount()>0){
        $dado = $sql->fetch();

        $nomeUsuario = $dado['nome'];
        $tipoUsuario = $dado['idtipo_usuario'];
        $_SESSION['tipoUsuario'] = $tipoUsuario;

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
        <title>Supervisores</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
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
                        <li class="nav-item"> <a class="nav-link" href="index.php"> Início </a> </li>
                       
                        <?php
                             if($tipoUsuario==2){
                        ?>
                        <li class="nav-item"> <a class="nav-link" href="form-solicitacao.php"> Nova Solicitação </a>  </li>
                        <?php         
                             }elseif($tipoUsuario==1){
                        ?>
                        <li class="nav-item"> <a class="nav-link" href="form-novo-supervisor.php"> Novo Supervisor </a> </li>
                        <?php        
                             }
                        ?>
                        <li class="nav-item"> <a class="nav-link" href='sair.php'>Sair</a> </li>
                    </ul>
                </nav>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th scope="col" class="text-center"> NOME </th>
                        <th scope="col" class="text-center">E-MAIL</th>
                        <th scope="col" class="text-center">AÇÕES</th>
                    </tr>
                    <?php
                        $sql = $db->query("SELECT * FROM usuarios WHERE idtipo_usuario=2");
                        if($sql->rowCount()>0){
                            $dados = $sql->fetchAll();
                            foreach($dados as $dado){
                                $idUsuarioListado = $dado['idusuarios'];
                    ?>
                    <tr>
                        <td class="text-center"> <?php echo $dado['nome']; ?> </td>
                        <td class="text-center"> <?php echo $dado['email']; ?> </td>
                        <td class="text-center"> 
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="menu-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opções
                                </button>
                                <div class="dropdown-menu" aria-labelledby="menu-drop">
                                    <a href="editar-supervisor.php?idUsuarioListado=<?php echo $idUsuarioListado ?>" class="dropdown-item"  data-toggle="modal" data-target="#modal<?php echo $idUsuarioListado; ?>" data-whatever="@mdo"> Editar </a>
                                    <a class="dropdown-item" href="excluir-supervisor.php?idUsuarioListado=<?php echo $idUsuarioListado ?>">Excluir</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- INICIO MODAL -->
                    <div class="modal fade" id="modal<?php echo $idUsuarioListado; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $dado['nome'] ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="atualiza-supervisor.php" method="post">
                                            
                                                <input type="hidden" name="idUsuarioListado" value="<?php echo $idUsuarioListado; ?>">
                                                <div class="form-group">
                                                    <label for="nome" class="col-form-label">Nome</label>
                                                    <input type="text" name="nome" class="form-control"  id="nome" value="<?php echo $dado['nome'];  ?>">
                                                </div>
                                                <div class="form-group ">
                                                    <label for="email" class="col-form-label">E-mail</label>
                                                    <input type="email" name="email" class="form-control" id="email" name="email" value="<?php echo $dado['email'];  ?>">
                                                </div>
                                                <div class="form-group ">
                                                    <label for="senha" class="col-form-label">Senha</label>
                                                    <input type="password" class="form-control" name="senha"  id="senha" required value="">
                                                </div>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="submit" name="analisar" class="btn btn-primary">Atualizar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIM MODAL -->
                    <?php            
                            }
                        }
                    ?>
                </table>
            </div>
        </div>

        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
    </body>
</html>