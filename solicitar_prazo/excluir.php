<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1){
    $idSolicitacao = $_GET['idSolicitacao'];

    $delete = $db->query("DELETE FROM solicitacoes_prazo WHERE idsolicitacoes_prazo = $idSolicitacao ");
    if($delete){
        echo "<script> alert('Excluído com Sucesso!')</script>";
        echo "<script> window.location.href='index.php' </script>";
    }else{
        echo "Erro";
    }
}else{
    echo "erro";
}

?>