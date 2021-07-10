<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false ){
    $idUsuario = $_SESSION[ 'idUsuario'];
    $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

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
        <title>Solicitações</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
        <link rel="manifest" href="assets/favicon/site.webmanifest">
        <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    </head>
    <body> 
        <div class="container-fluid"> 
            <div class="cabecalho">
                <a href="index.php"><img src="assets/images/logo.png" alt=""></a> 
                <div class="titulo">Basto Mesquita Dist e Logistica</div>
            </div>

            <div class="menu">

                <div class="form-filtro">
                    <form action="" class="form-inline" method="post">
                        <div class="form-row">
                            <select name="codCliente" id="codCliente" class="form-control">
                                <option value=""></option>
                                <?php
                                    $filtrado = $db->query("SELECT codigo_cliente FROM solicitacoes_prazo");
                                    if($filtrado->rowCount()>0){
                                        $dados = $filtrado->fetchAll();
                                        foreach($dados as $dado){
                                ?>
                                <option value="<?php echo $dado['codigo_cliente'] ?>"><?php echo $dado['codigo_cliente'] ?></option>
                                <?php            
                                        }
                                    }
                                ?>
                            </select>
                            <input type="submit" value="Filtrar" name="filtro" class="btn btn-success">
                        </div>
                    </form>
                </div>

                <img class="menu-mobile" src="assets/images/menu.png" alt="" onclick="abrirMenu()">
                <nav id="menuMobile">
                    <ul class="nav flex-column">
                       
                        <?php
                             if($tipoUsuario==2){
                        ?>
                        <li class="nav-item"> <a class="nav-link" href="form-solicitacao.php"> Nova Solicitação </a>  </li>
                        <?php         
                             }elseif($tipoUsuario==1){
                        ?>
                       <li class="nav-item"> <a class="nav-link" href="gerar-planilha.php"> Gerar Planilha</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="form-novo-supervisor.php"> Novo Supervisor </a> </li>
                        <li class="nav-item"> <a class="nav-link" href="supervisores.php"> Supervisores</a> </li>
                        

                        <?php        
                             }
                        ?>
                        <li class="nav-item"> <a class="nav-link" href='sair.php'>Sair</a> </li>
                    </ul>
                </nav>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="">
                        <?php
                        
                            if($tipoUsuario==1){
                                $sql = $db->query("SELECT solicitacoes_prazo.*, usuarios.nome FROM solicitacoes_prazo INNER JOIN usuarios ON solicitacoes_prazo.idusuarios = usuarios.idusuarios ORDER BY data_solicitacao ASC");
                        ?>
                        <tr>
                            <th scope="col" class="text-center">  Data Solicitação </th>
                            <th scope="col" class="text-center">  Serasa </th>
                            <th scope="col" class="text-center">  Código Cliente </th>
                            <th scope="col" class="text-center">  Nome Cliente </th>
                            <th scope="col" class="text-center">  Telefone </th>
                            <th scope="col" class="text-center">  RCA </th>
                            <th scope="col" class="text-center">  Obs </th>
                            <th scope="col" class="text-center">  Anexos </th>
                            <th scope="col" class="text-center">Prazo</th>
                            <th scope="col" class="text-center">  Status </th>
                            <th scope="col" class="text-center">  Solicitante </th>
                            <th scope="col" class="text-center"> Ações</th>
                        </tr>
                        <?php

                            $totalSolic = $sql->rowCount();
                            $qtdPagina = 10;
                            $numPaginas = ceil($totalSolic/$qtdPagina);
                            $paginaInicial = ($qtdPagina*$pagina)-$qtdPagina;
                            

                            if(isset($_POST['filtro']) && empty($_POST['codCliente'])==false ){
                                $codCliente = filter_input(INPUT_POST, 'codCliente');
                                $filtrado = $db->query("SELECT solicitacoes_prazo.*, usuarios.nome FROM solicitacoes_prazo INNER JOIN usuarios ON solicitacoes_prazo.idusuarios = usuarios.idusuarios AND solicitacoes_prazo.codigo_cliente = '$codCliente' ORDER BY data_solicitacao DESC");

                                if($filtrado->rowCount()>0){
                                    $dados = $filtrado->fetchAll();
                                    foreach($dados as $dado){
                                        $idPrazo = $dado['idsolicitacoes_prazo'];
                        ?>
                            <tr>
                                <td scope="col" class="text-center"> <?php echo date("d/m/Y", strtotime($dado['data_solicitacao']));  ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['serasa']; ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['codigo_cliente']; ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['nome_cliente']; ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['fone']; ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['rca']; ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['obs']; ?> </td>
                                <?php 
                                
                                    $link = $dado['anexos'];
                                    if($link==""){
                                ?>
                                    <td scope="col" class="text-center"> <a target="_blank" href=""> Sem Anexo </a> </td>
                                <?php
                                    }else{
                                ?>
                                    <td scope="col" class="text-center"> <a target="_blank" href="uploads/<?php echo $idPrazo ?>" > Anexos </a> </td>
                                <?php        
                                    }
                                ?>
                                
                                <td scope="col" class="text-center"> <?php echo $dado['prazo_dias']; ?> Dias </td>
                                <td scope="col" class="text-center"> <?php echo $dado['status_solicitacao']; ?> </td>
                                <td scope="col" class="text-center"> <?php echo $dado['nome']; ?> </td>
                                <td scope="col" class="text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?php echo $idPrazo; ?>" data-whatever="@mdo" value="<?php echo $idPrazo; ?>" name="idSolic" >Visualisar</button>
                                </td>
                            </tr>
                            <!-- INICIO MODAL -->
                            <div class="modal fade" id="modal<?php echo $idPrazo; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Solicitante:<?php echo $dado['nome'] ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="analise.php" method="post">
                                                <div class="form-row">
                                                    <input type="hidden" name="idSolicitacao" value="<?php echo $idPrazo; ?>">
                                                    <div class="form-group col-md-12">
                                                        <label for="data_solicitacao" class="col-form-label">Data Solicitação</label>
                                                        <input type="text" class="form-control" Readonly id="data_solicitacao" value="<?php echo date("d/m/Y",strtotime($dado['data_solicitacao']));  ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="codigo_cliente" class="col-form-label">Código Cliente</label>
                                                        <input type="text" class="form-control" name="codigo_cliente" Readonly id="codigo_cliente" value="<?php echo $dado['codigo_cliente'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="nome_cliente" class="col-form-label">Nome Cliente</label>
                                                        <input type="text" class="form-control" name="nome_cliente" Readonly id="nome_cliente" value="<?php echo $dado['nome_cliente'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="fone" class="col-form-label">Telefone</label>
                                                        <input type="text" class="form-control" name="fone" Readonly id="fone" value="<?php echo $dado['fone'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="fone2" class="col-form-label">Telefone 2</label>
                                                        <input type="text" class="form-control" name="fone2" Readonly id="fone2" value="<?php echo $dado['fone2'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="prazo" class="col-form-label">Prazo</label>
                                                        <input type="text" class="form-control" name="prazo" Readonly id="prazo" value="<?php echo $dado['prazo_dias']." Dias" ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="rca" class="col-form-label">RCA</label>
                                                        <input type="text" class="form-control" name="rca" Readonly id="rca" value="<?php echo $dado['rca'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="obs" class="col-form-label">OBS</label>
                                                        <input type="text" class="form-control" name="obs" Readonly id="obs" value="<?php echo $dado['obs'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="firma" class="col-form-label">Firma no Nome?</label>
                                                        <input type="text" class="form-control" name="firma" Readonly id="firma" value="<?php echo $dado['firma_no_nome'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="predio" class="col-form-label">Prédio Próprio</label>
                                                        <input type="text" class="form-control" name="predio" Readonly id="predio" value="<?php echo $dado['predio_proprio'] ?>">
                                                    </div>
                                                </div>
                                                <?php
                                                
                                                if($dado['anexos'] != ""){
                                                ?>
                                                <div class="form-group col-md-12">
                                                    <div class="image-modal">
                                                        <a target="_blank" href="uploads/<?php echo $idSolicitacao ?>" > Anexos </a>
                                                    </div>  
                                                </div>
                                                <?php

                                                }
                                                
                                                ?>
                                                
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="status" class="col-form-label">Status</label>
                                                        <select name="status" id="status" class="custom-select">
                                                            <option value="<?php echo $dado['status_solicitacao'] ?>"><?php echo $dado['status_solicitacao'] ?></option>
                                                            <option value="Aprovado">Aprovado</option>
                                                            <option value="Reprovado">Reprovado</option>
                                                            <option value="Em Análise">Em Análise</option>
                                                            <option value="Cliente não Atende">Cliente não Atende</option>
                                                            <option value="Cliente Fora de Área">Cliente Fora de Área</option>
                                                            <option value="Cliente Fora de Área">Sem foto</option>
                                                            <option value="Cliente Fora de Área">Analisado</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="serasa" class="col-form-label">Serasa</label>
                                                        <input type="text" name="serasa" id="serasa" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="obsAnalise"> Obs de Análise </label>
                                                        <input type="text" name="obsAnalise" class="form-control">
                                                    </div>
                                                </div>
                                                
                                            
                                        </div>
                                        <div class="modal-footer">
                                                <a href="excluir.php?idSolicitacao=<?php echo $idPrazo; ?>" class="btn btn-danger" > Excluir </a>
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
                            }else{
                                $resul = $db->query("SELECT solicitacoes_prazo.*, usuarios.nome FROM solicitacoes_prazo INNER JOIN usuarios ON solicitacoes_prazo.idusuarios = usuarios.idusuarios ORDER BY data_solicitacao DESC LIMIT $paginaInicial, $qtdPagina");

                                if($resul->rowCount()>0){
                                    $dados = $resul->fetchAll();
                                    foreach($dados as $dado){
                                        $idSolicitacao = $dado['idsolicitacoes_prazo'];
                        ?>
                            <tr>
                            <td scope="col" class="text-center"> <?php echo date("d/m/Y", strtotime($dado['data_solicitacao']));  ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['serasa']; ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['codigo_cliente']; ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['nome_cliente']; ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['fone']; ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['rca']; ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['obs']; ?> </td>
                            <?php 
                            
                                $link = $dado['anexos'];
                                if($link==""){
                            ?>
                                <td scope="col" class="text-center"> <a target="_blank" href=""> Sem Anexo </a> </td>
                            <?php
                                }else{
                            ?>
                                <td scope="col" class="text-center"> <a target="_blank" href="uploads/<?php echo $idSolicitacao ?>" > Anexos </a> </td>
                            <?php        
                                }
                            ?>
                            
                            <td scope="col" class="text-center"> <?php echo $dado['prazo_dias']; ?> Dias </td>
                            <td scope="col" class="text-center"> <?php echo $dado['status_solicitacao']; ?> </td>
                            <td scope="col" class="text-center"> <?php echo $dado['nome']; ?> </td>
                            <td scope="col" class="text-center">
                                
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?php echo $idSolicitacao; ?>" data-whatever="@mdo" value="<?php echo $idSolicitacao ?>" name="idSolic" >Visualisar</button>
                            </td>
                            </tr>
                            <!-- INICIO MODAL -->
                            <div class="modal fade" id="modal<?php echo $idSolicitacao; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Solicitante: <?php echo $dado['nome'] ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="analise.php" method="post">
                                                <div class="form-row">
                                                    <input type="hidden" name="idSolicitacao" value="<?php echo $idSolicitacao; ?>">
                                                    <div class="form-group col-md-12">
                                                        <label for="data_solicitacao" class="col-form-label">Data Solicitação</label>
                                                        <input type="text" class="form-control" Readonly id="data_solicitacao" value="<?php echo date("d/m/Y",strtotime($dado['data_solicitacao']));  ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="codigo_cliente" class="col-form-label">Código Cliente</label>
                                                        <input type="text" class="form-control" name="codigo_cliente" Readonly id="codigo_cliente" value="<?php echo $dado['codigo_cliente'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="nome_cliente" class="col-form-label">Nome Cliente</label>
                                                        <input type="text" class="form-control" name="nome_cliente" Readonly id="nome_cliente" value="<?php echo $dado['nome_cliente'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="fone" class="col-form-label">Telefone</label>
                                                        <input type="text" class="form-control" name="fone" Readonly id="fone" value="<?php echo $dado['fone'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="fone2" class="col-form-label">Telefone 2</label>
                                                        <input type="text" class="form-control" name="fone2" Readonly id="fone2" value="<?php echo $dado['fone2'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="prazo" class="col-form-label">Prazo</label>
                                                        <input type="text" class="form-control" name="prazo" Readonly id="prazo" value="<?php echo $dado['prazo_dias']." Dias" ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="rca" class="col-form-label">RCA</label>
                                                        <input type="text" class="form-control" name="rca" Readonly id="rca" value="<?php echo $dado['rca'] ?>">
                                                    </div> 
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="obs" class="col-form-label">OBS</label>
                                                        <input type="text" class="form-control" name="obs" Readonly id="obs" value="<?php echo $dado['obs'] ?>">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="firma" class="col-form-label">Firma no Nome?</label>
                                                        <input type="text" class="form-control" name="firma" Readonly id="firma" value="<?php echo $dado['firma_no_nome'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="predio" class="col-form-label">Prédio Próprio</label>
                                                        <input type="text" class="form-control" name="predio" Readonly id="predio" value="<?php echo $dado['predio_proprio'] ?>">
                                                    </div>
                                                </div>
                                                <?php
                                                
                                                if($dado['anexos'] != ""){
                                                ?>
                                                <div class="form-group col-md-12">
                                                    <div class="image-modal">
                                                        <a target="_blank" href="uploads/<?php echo $idSolicitacao ?>" > Anexos </a>
                                                    </div>  
                                                </div>
                                                <?php

                                                }
                                                
                                                ?>
                                                
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="status" class="col-form-label">Status</label>
                                                        <select name="status" id="status" class="custom-select">
                                                            <option value="<?php echo $dado['status_solicitacao'] ?>"><?php echo $dado['status_solicitacao'] ?></option>
                                                            <option value="Aprovado">Aprovado</option>
                                                            <option value="Reprovado">Reprovado</option>
                                                            <option value="Em Análise">Em Análise</option>
                                                            <option value="Cliente não Atende">Cliente não Atende</option>
                                                            <option value="Cliente Fora de Área">Cliente Fora de Área</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="serasa" class="col-form-label">Serasa</label>
                                                        <input type="text" name="serasa" id="serasa" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="obsAnalise"> Obs de Análise </label>
                                                        <input type="text" name="obsAnalise" class="form-control">
                                                    </div>
                                                </div>
                                                
                                            
                                        </div>
                                        <div class="modal-footer">
                                                <a href="excluir.php?idSolicitacao=<?php echo $idSolicitacao; ?>" class="btn btn-danger" > Excluir </a>
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
                                }
                            }elseif($tipoUsuario==2){
                                $sql = $db->query("SELECT * FROM solicitacoes_prazo WHERE idusuarios = $idUsuario ORDER BY data_solicitacao");
                        ?>
                        <tr>
                            <th scope="col" class="text-center"> Data Solicitação</th>
                            <th scope="col" class="text-center"> Serasa</th>
                            <th scope="col" class="text-center"> Código Cliente</th>
                            <th scope="col" class="text-center"> Nome Cliente</th>
                            <th scope="col" class="text-center"> RCA</th>
                            <th scope="col" class="text-center"> Prazo </th>
                            <th scope="col" class="text-center"> Status</th>
                            <th scope="col" class="text-center"> Obs de Análise</th>
                            <th scope="col" class="text-center"> Ações</th>
                        </tr>
                        <?php  
                            $totalSolic = $sql->rowCount();
                            $qtdPagina = 8;
                            $numPaginas = ceil($totalSolic/$qtdPagina);
                            $paginaInicial = ($qtdPagina*$pagina)-$qtdPagina;
                            $resul = $db->query("SELECT * FROM solicitacoes_prazo WHERE idusuarios = $idUsuario ORDER BY data_solicitacao DESC LIMIT $paginaInicial, $qtdPagina");
                                if($resul->rowCount()>0){
                                    $dados = $resul->fetchAll();
                                    foreach($dados as $dado){
                                        $idSolicitacao = $dado['idsolicitacoes_prazo'];
                        ?>
                        <tr>
                            <td class="text-center"> <?php echo date("d-m-Y", strtotime($dado['data_solicitacao'])); ?> </td>
                            <td class="text-center"> <?php echo $dado['serasa']; ?> </td>
                            <td class="text-center"> <?php echo $dado['codigo_cliente']; ?> </td>
                            <td class="text-center"> <?php echo $dado['nome_cliente']; ?> </td>
                            <td class="text-center"> <?php echo $dado['rca']; ?> </td>
                            <td class="text-center"> <?php echo $dado['prazo_dias']. " Dias"; ?> </td>
                            <td class="text-center"> <?php echo $dado['status_solicitacao']; ?> </td>
                            <td class="text-center"> <?php echo $dado['obs_analise']; ?> </td>
                            <td scope="col" class="text-center">
                                
                                <?php
                                    if($dado['status_solicitacao']!="Reprovado" && $dado['status_solicitacao']!="Aprovado"){
                                ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal<?php echo $idSolicitacao; ?>" data-whatever="@mdo" value="<?php echo $idSolicitacao ?>" name="idSolic" >Editar</button>
                                <?php        
                                    }
                                ?>
                                
                            </td>

                        </tr>
                        <!-- INICIO MODAL supervisor-->
                        <div class="modal fade" id="modal<?php echo $idSolicitacao; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="editar-solic.php"  method="post"  enctype="multipart/form-data">
                                            <div class="form-row">
                                                <input type="hidden" name="idSolicitacao" value="<?php echo $idSolicitacao; ?>">
                                                <div class="form-group col-md-12">
                                                    <label for="data_solicitacao" class="col-form-label">Data Solicitação</label>
                                                    <input type="text" class="form-control" Readonly id="data_solicitacao" value="<?php echo date("d/m/Y",strtotime($dado['data_solicitacao']));  ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="codigo_cliente" class="col-form-label">Código Cliente</label>
                                                    <input type="text" class="form-control" name="codigo_cliente" id="codigo_cliente" value="<?php echo $dado['codigo_cliente'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="nome_cliente" class="col-form-label">Nome Cliente</label>
                                                    <input type="text" class="form-control" name="nome_cliente" id="nome_cliente" value="<?php echo $dado['nome_cliente'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="fone" class="col-form-label">Telefone</label>
                                                    <input type="text" class="form-control" name="fone" id="fone" value="<?php echo $dado['fone'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fone2" class="col-form-label">Telefone 2</label>
                                                    <input type="text" class="form-control" name="fone2" id="fone2" value="<?php echo $dado['fone2'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="prazo" class="col-form-label">Prazo</label>
                                                    <input type="text" class="form-control" name="prazo" id="prazo" value="<?php echo $dado['prazo_dias']." Dias" ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="rca" class="col-form-label">RCA</label>
                                                    <input type="text" class="form-control" name="rca" id="rca" value="<?php echo $dado['rca'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="obs" class="col-form-label">OBS</label>
                                                    <input type="text" class="form-control" name="obs" id="obs" value="<?php echo $dado['obs'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="firma" class="col-form-label">Firma no Nome?</label>
                                                    <input type="text" class="form-control" name="firma" id="firma" value="<?php echo $dado['firma_no_nome'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="predio" class="col-form-label">Prédio Próprio</label>
                                                    <input type="text" class="form-control" name="predio" id="predio" value="<?php echo $dado['predio_proprio'] ?>">
                                                </div>
                                            </div>
                                            <?php
                                            
                                            //if($dado['anexos'] != ""){
                                            ?>
                                            <div class="form-group col-md-12">
                                                <label for="anexo" >Inserir Arquivos</label>
                                                <input type="file" name="anexos[]" multiple="multiple" id="anexo" class="form-control-file">
                                            </div>
                                            <?php

                                            //}
                                            
                                            ?>
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
                            }
                        ?>

                    </thead>
                </table>
            </div>
            <?php
            
                $paginaAnterior = $pagina-1;
                $paginaPosterior = $pagina+1;
                            
            ?>
            <nav aria-label="Navegação de página exemplo" class="paginacao">
                <ul class="pagination">
                    <li class="page-item">
                    <?php
                        if($paginaAnterior!=0){
                            echo "<a class='page-link' href='index.php?pagina=$paginaAnterior' aria-label='Anterior'>
                            <span aria-hidden='true'>&laquo;</span>
                            <span class='sr-only'>Anterior</span>
                        </a>";
                        }else{
                            echo "<a class='page-link' aria-label='Anterior'> 
                                <span aria-hidden='true'>&laquo;</span>
                                <span class='sr-only'>Anterior</span>
                            </a>";
                        }
                    ?>
                    
                    </li>
                    <?php
                        for($i=1;$i < $numPaginas+1;$i++){
                            echo "<li class='page-item'><a class='page-link' href='index.php?pagina=$i'>$i</a></li>";
                        }
                    ?>
                    <li class="page-item">
                    <?php
                        if($paginaPosterior <= $numPaginas){
                            echo " <a class='page-link' href='index.php?pagina=$paginaPosterior' aria-label='Próximo'>
                            <span aria-hidden='true'>&raquo;</span>
                            <span class='sr-only'>Próximo</span>
                        </a>";
                        }else{
                            echo " <a class='page-link' aria-label='Próximo'>
                                    <span aria-hidden='true'>&raquo;</span>
                                    <span class='sr-only'>Próximo</span>
                            </a> ";
                        }
                    ?>
                   
                    </li>
                </ul>
            </nav>
        </div>      

        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/js/jquery.mask.js"></script>
        <script>
            $(document).ready(function(){
                $('#fone').mask('(99) 99999-9999');
                $('#fone2').mask('(99) 99999-9999');
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#codCliente').select2();
            });
        </script>
    </body>
</html>