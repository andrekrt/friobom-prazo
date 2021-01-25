<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false){

    $nome = filter_input(INPUT_POST,'nome');
    $email = filter_input(INPUT_POST,'email');
    $senha = md5(filter_input(INPUT_POST, 'senha'));
    $tipoUsuario = 2;

 
    $consulta = $db->query("SELECT email FROM usuarios WHERE email= '$email' ");
    if($consulta->rowCount()>0){
        echo "<script> alert('E-mail já Cadastrado')</script>";
        echo "<script> window.location.href='form-novo-supervisor.php' </script>";
    }else{
        $cadastrar = $db->query("INSERT INTO usuarios (nome, email, senha, idtipo_usuario) VALUES ('$nome', '$email', '$senha', $tipoUsuario)");

        if($cadastrar){
            echo "<script> alert('Supervisor Cadastrado com Sucesso')</script>";
            echo "<script> window.location.href='index.php' </script>";
        }else{
            echo "Erro";
        }
    }

    
    

}else{
    header("Location:index.php");
}

?>