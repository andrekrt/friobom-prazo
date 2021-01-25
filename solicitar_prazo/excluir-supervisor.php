<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1){
    $idSupervisor = $_GET['idUsuarioListado'];

    $delete = $db->query("DELETE FROM usuarios WHERE idusuarios = '$idSupervisor' ");
    if($delete){
        echo "<script> alert('Excluído com Sucesso!')</script>";
        echo "<script> window.location.href='supervisores.php' </script>";
    }else{
        echo "erro de exclusão";
    }
}else{
    echo "erro";
}

?>