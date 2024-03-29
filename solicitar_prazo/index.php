<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false ){
    $idUsuario = $_SESSION[ 'idUsuario'];
    $tipoUsuario = $_SESSION['tipoUsuario'];

    if($tipoUsuario==1){
        header("Location:solicitacoes.php");
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

        <!-- arquivos para datatable -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.css"/>
    </head>
    <body> 
        <div class="container-fluid corpo">
            <div class="menu-lateral" id="menu-lateral">
                <div class="logo">
                    <img src="assets/images/logo-red.png" >
                </div>
                <div class="opcoes">
                    <div class="item">
                        <a href="form-solicitacao.php"> <img src="assets/images/nova-solicitacao.png" > </a>
                    </div>
                    <div class="item">
                        <a href="sair.php"> <img src="assets/images/sair.png"> </a>
                    </div>
                </div>
            </div>
            <!-- Tela com os dados -->
            <div class="tela-principal">
                <div class="menu-superior">
                    <div class="icone-menu-superior">
                        <img src="assets/images/icone-solicitacao.png" alt="">
                    </div>
                    <div class="title">
                        <h2>Solicitações</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="assets/images/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <!-- dados exclusivo da página-->
                <div class="menu-principal">
                    <!-- <div class="icon-exp">
                        <a href="rescisoes-xls.php"><img src="../assets/images/excel.jpg" alt=""></a>
                    </div> -->
                    <div class="table-responsive">
                        <table id='prazos' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                            <thead>

                                <tr>
                                    <th scope="col" class="text-center text-nowrap" > Data Solicitação </th>
                                    <th scope="col" class="text-center text-nowrap" > Serasa </th>
                                    <th scope="col" class="text-center text-nowrap">Código Cliente</th>
                                    <th scope="col" class="text-center text-nowrap"> Nome Cliente</th>   
                                    <th scope="col" class="text-center text-nowrap"> RCA </th>  
                                    <th scope="col" class="text-center text-nowrap"> Prazo </th> 
                                    <th scope="col" class="text-center text-nowrap"> Status </th>       
                                    <th scope="col" class="text-center text-nowrap"> Restrição </th> 
                                    <th scope="col" class="text-center text-nowrap"> Obs de Análise</th> 
                                    <th scope="col" class="text-center text-nowrap"> Ações </th> 
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>     

        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/af-2.3.7/date-1.1.0/r-2.2.9/rg-1.1.3/sc-2.0.4/sp-1.3.0/datatables.min.js"></script>

        <script>
            $(document).ready(function(){
                $('#prazos').DataTable({
                    'processing':true,
                    'serverSide':true,
                    'serverMethod':'post',
                    'ajax':{
                        'url':'pesq_prazos.php'
                    },
                    'columns':[
                        { data: 'data_solicitacao'},
                        { data: 'serasa'},
                        { data: 'codigo_cliente'},
                        { data: 'nome_cliente'},
                        { data: 'rca'},
                        { data: 'prazo_dias'},
                        { data: 'status_solicitacao'},
                        { data: 'restricao'},
                        { data: 'obs_analise'},
                        { data: 'acoes'}
                    ],
                    "language":{
                        "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                    },
                    "order":[[0, "desc"]]
                });
            });

            $('#prazos').on('click', '.editbtn', function(event){
                var table = $('#prazos').DataTable();
                var trid = $(this).closest('tr').attr('id');
                var id = $(this).data('id');

                $('#modalEditar').modal('show');

                $.ajax({
                    url:"get_desc.php",
                    data:{id:id},
                    type:'post',
                    success: function(data){
                        var json = JSON.parse(data);
                        
                        $('#idSolicitacao').val(json.idsolicitacoes_prazo);
                        $('#data_solicitacao').val(json.data_solicitacao);
                        $('#serasa').val(json.serasa);
                        $('#codigo_cliente').val(json.codigo_cliente);
                        $('#nome_cliente').val(json.nome_cliente);
                        $('#fone').val(json.fone);
                        $('#fone2').val(json.fone2);
                        $('#prazo').val(json.prazo_dias);
                        $('#rca').val(json.rca);
                        $('#firma').val(json.firma_no_nome);
                        $('#predio').val(json.predio_proprio);
                        $('#obs').val(json.obs);
                        $('#tokenDesc').val(json.status_solicitacao);
                        $('#tokenDesc').val(json.restricao);
                        $('#tokenDesc').val(json.obs_analise);
                    }
                });
            });
        </script>

        <!-- INICIO MODAL supervisor-->
        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="editar-solic.php"  method="post"  enctype="multipart/form-data">
                            <div class="form-row">
                                <input type="hidden" name="idSolicitacao" id="idSolicitacao">
                                <div class="form-group col-md-12">
                                    <label for="data_solicitacao" class="col-form-label">Data Solicitação</label>
                                    <input type="date" class="form-control" Readonly id="data_solicitacao" value="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="codigo_cliente" class="col-form-label">Código Cliente</label>
                                    <input type="text" class="form-control" name="codigo_cliente" id="codigo_cliente" value="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nome_cliente" class="col-form-label">Nome Cliente</label>
                                    <input type="text" class="form-control" name="nome_cliente" id="nome_cliente" value="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fone" class="col-form-label">Telefone</label>
                                    <input type="text" class="form-control" name="fone" id="fone" value="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fone2" class="col-form-label">Telefone 2</label>
                                    <input type="text" class="form-control" name="fone2" id="fone2" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="prazo" class="col-form-label">Prazo</label>
                                    <input type="text" class="form-control" name="prazo" id="prazo" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rca" class="col-form-label">RCA</label>
                                    <input type="text" class="form-control" name="rca" id="rca" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="obs" class="col-form-label">OBS</label>
                                    <input type="text" class="form-control" name="obs" id="obs" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firma" class="col-form-label">Firma no Nome?</label>
                                    <input type="text" class="form-control" name="firma" id="firma" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="predio" class="col-form-label">Prédio Próprio</label>
                                    <input type="text" class="form-control" name="predio" id="predio" >
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
    </body>

   
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jquery.mask.js"></script>
    <script src="assets/js/menu.js"></script>
    <script>
        $(document).ready(function(){
            $('#fone').mask('(99) 99999-9999');
            $('#fone2').mask('(99) 99999-9999');
        });
    </script>
    
</html>