<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false && $_SESSION['tipoUsuario']==1){
    $idUsuarioListado = filter_input(INPUT_POST, 'idUsuarioListado');
    $nome = filter_input(INPUT_POST, 'nome');
    $email = filter_input(INPUT_POST, 'email');
    $senha = md5(filter_input(INPUT_POST, 'senha'));

    $atualiza = $db->query("UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha' ");
    if($atualiza){
        echo "<script> alert('Dados Atualizado com Sucesso')</script>";
        echo "<script> window.location.href='supervisores.php' </script>";
    }
}else{
    echo "erro";
}

?>