<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario']) == false ){
    
    $idUsuario = $_SESSION['idUsuario'];
    $dataSolicitacao = date("Y/m/d");
    $codigoCliente = filter_input(INPUT_POST, 'cod_cliente');
    $nomeCliente = filter_input(INPUT_POST, 'nome_cliente');
    $fone = filter_input(INPUT_POST, 'fone');
    $fone2 = filter_input(INPUT_POST, 'fone2');
    $prazo = filter_input(INPUT_POST, 'prazo');
    $rca = filter_input(INPUT_POST, 'rca');
    $obs = filter_input(INPUT_POST, 'obs');
    $firma = filter_input(INPUT_POST, 'firma_no_nome');
    $predio = filter_input(INPUT_POST, 'predio');
    $anexo = $_FILES['anexos'];
    $anexo_nome01 = $anexo['name'][0];
    
    $statusSolicitacao = "Em Análise";

    $consulta = $db->query("SELECT * FROM `solicitacoes_prazo` WHERE codigo_cliente = '$codigoCliente' AND status_solicitacao = 'Aprovado' ");
    

    if($consulta->rowCount()>0){
        echo "<script> alert('Já existe solicitação para esse cliente')</script>";
        echo "<script> window.location.href='index.php' </script>";
    }else{
        $inserir = $db->query("INSERT INTO solicitacoes_prazo (data_solicitacao, codigo_cliente, nome_cliente, fone,fone2, prazo_dias, rca, firma_no_nome, predio_proprio, obs, anexos, status_solicitacao, idusuarios) VALUES ('$dataSolicitacao', '$codigoCliente', '$nomeCliente', '$fone', '$fone2', '$prazo', '$rca', '$firma', '$predio', '$obs', '$anexo_nome01', '$statusSolicitacao', '$idUsuario')");
        
        if($inserir){
            //header("Location:index.php");
            $ultimoid = $db->lastInsertId();
            $diretorio = "uploads/". $ultimoid;
            mkdir($diretorio, 0755);
            for($i=0;$i<count($anexo['name']); $i++){
                $destino = "uploads/".$ultimoid."/".$anexo['name'] [$i];
                move_uploaded_file($anexo['tmp_name'][$i], $destino);
                
            }
            echo "<script> alert('Solicitação Cadastrada com Sucesso')</script>";
            echo "<script> window.location.href='index.php' </script>";
        
        }else{
            echo "Erro no cadastro";
        }

    }

    

    
    
    /*pasta = "uploads/";
    $mover = move_uploaded_file($_FILES['anexo']['tmp_name'], $pasta.$anexo);*/
    
    

}else{
    header("Location:login.php");
}

?>

