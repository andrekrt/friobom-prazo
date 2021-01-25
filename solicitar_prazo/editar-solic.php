<?php

session_start();
require("conexao.php");

if(isset($_SESSION['idUsuario']) && empty($_SESSION['idUsuario'])==false && $_SESSION['tipoUsuario'] == 2){
    $idSolic = filter_input(INPUT_POST, 'idSolicitacao');
    $codCliente = filter_input(INPUT_POST, 'codigo_cliente');
    $nomeCliente = filter_input(INPUT_POST, 'nome_cliente');
    $fone01 = filter_input(INPUT_POST, 'fone');
    $fone02 = filter_input(INPUT_POST, 'fone2');
    $prazo = filter_input(INPUT_POST,'prazo');
    $rca = filter_input(INPUT_POST, 'rca');
    $obs = filter_input(INPUT_POST, 'obs');
    $firma = filter_input(INPUT_POST, 'firma');
    $predio = filter_input(INPUT_POST, 'predio');
    $anexo = $_FILES['anexos'];
    $anexo_nome01 = $anexo['name'][0];

    
    $atualizar = $db->query("UPDATE solicitacoes_prazo SET codigo_cliente='$codCliente', nome_cliente = '$nomeCliente', fone = '$fone01', fone2 = '$fone02', prazo_dias = '$prazo', rca = '$rca', firma_no_nome = '$firma', predio_proprio = '$predio', anexos = '$anexo_nome01' WHERE idsolicitacoes_prazo = $idSolic ");

    if($atualizar){
        if($anexo != " "){
            $diretorio = "uploads/".$idSolic;
            mkdir($diretorio, 0755);
            for($i=0;$i<count($anexo['name']); $i++){
                $destino = "uploads/".$idSolic."/".$anexo['name'] [$i];
                if(move_uploaded_file($anexo['tmp_name'][$i], $destino)){
                    echo "<script> alert('Dados Atualizado com Sucesso')</script>";
                    echo "<script> window.location.href='index.php' </script>";
                }else{
                    echo "Erro no upload dos arquivos";
                }
                
            }
        }else{
            echo "<script> alert('Dados Atualizado com Sucesso')</script>";
            echo "<script> window.location.href='index.php' </script>";
        }
        
    }else{
        echo "Erro: consultar o administrador";
    }
}else{
    header("Location:index.php");
}

?>