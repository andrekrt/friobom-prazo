<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario']==1){
    $idUsuario = $_SESSION[ 'idUsuario'];

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
                        <img src="assets/images/icone-supervisor.png" alt="">
                    </div>
                    <div class="title">
                        <h2>Supervisores</h2>
                    </div>
                    <div class="menu-mobile">
                        <img src="assets/images/menu-mobile.png" onclick="abrirMenuMobile()" alt="">
                    </div>
                </div>
                <div class="menu-principal">
                    <div class="table-responsive">
                        <table id='supervisores' class='table table-striped table-bordered nowrap text-center' style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center text-nowrap" > ID </th>
                                    <th scope="col" class="text-center text-nowrap" > Nome </th>
                                    <th scope="col" class="text-center text-nowrap" > E-mail </th>  
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
                $('#supervisores').DataTable({
                    'processing':true,
                    'serverSide':true,
                    'serverMethod':'post',
                    'ajax':{
                        'url':'pesq_sup.php'
                    },
                    'columns':[
                        { data: 'idusuarios'},
                        { data: 'nome'},
                        { data: 'email'},
                        { data: 'acoes'}
                    ],
                    "language":{
                        "url":"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                    },
                }); 
            });

            $('#supervisores').on('click', '.editbtn', function(event){
                var table = $('#supervisores').DataTable();
                var trid = $(this).closest('tr').attr('id');
                var id = $(this).data('id');

                $('#modalEditar').modal('show');

                $.ajax({
                    url:"get_sup.php",
                    data:{id:id},
                    type:'post',
                    success: function(data){
                        var json = JSON.parse(data);
                        
                        $('#idusuario').val(json.idusuarios);
                        $('#email').val(json.email);
                        $('#nome').val(json.nome);                    
                    }
                });
            });
        </script>

        <!-- INICIO MODAL -->
        <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supervisor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="atualiza-supervisor.php" method="post">
                                <input type="hidden" name="idUsuarioListado" id="idusuario" >
                                <div class="form-group">
                                    <label for="nome" class="col-form-label">Nome</label>
                                    <input type="text" name="nome" class="form-control"  id="nome" >
                                </div>
                                <div class="form-group ">
                                    <label for="email" class="col-form-label">E-mail</label>
                                    <input type="email" name="email" class="form-control" id="email" name="email" >
                                </div>
                                <div class="form-group ">
                                    <label for="senha" class="col-form-label">Senha</label>
                                    <input type="password" class="form-control" name="senha"  id="senha" required >
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

        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/js/jquery.mask.js"></script>
        <script src="assets/js/menu.js"></script>
    </body>
</html>