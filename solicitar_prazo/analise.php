<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1){

    $idSolicitacao = filter_input(INPUT_POST, 'idSolicitacao');
    $status_solicitacao = filter_input(INPUT_POST, 'status');
    $data_aprovacao = "0000/00/00";
    $serasa = filter_input(INPUT_POST, 'serasa');
    $obsAnalise = filter_input(INPUT_POST, 'obsAnalise');
    $restricao = filter_input(INPUT_POST, 'restricao');

    if($status_solicitacao=="Aprovado"){
        $data_aprovacao = date("Y-m-d");
    }

    $atualiza = $db->query("UPDATE solicitacoes_prazo SET status_solicitacao = '$status_solicitacao', data_aprovocao = '$data_aprovacao', serasa = '$serasa', obs_analise = '$obsAnalise', restricao = '$restricao' WHERE idsolicitacoes_prazo = $idSolicitacao ");

    if($atualiza){
        echo "<script> alert('Solicitação Analisada com Sucesso')</script>";
        echo "<script> window.location.href='index.php' </script>";
    }else{
        echo "Erro";
    }

}else{
    header("Location:index.php");
}

?>