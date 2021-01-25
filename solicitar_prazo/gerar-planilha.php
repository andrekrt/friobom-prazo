<?php

session_start();
require("conexao.php");

$tipoUsuario = $_SESSION['tipoUsuario'];

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Planilha</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <?php
        
            if($tipoUsuario==1){
                $arquivo = 'prazo.xls';
                $html = '';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<td class="text-center" colspan="13" > PRAZOS </td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<td class="text-center font-weight-bold"> Data da Solicitação </td>';
                $html .= '<td class="text-center font-weight-bold"> Serasa </td>';
                $html .= '<td class="text-center font-weight-bold"> Código Cliente </td>';
                $html .= '<td class="text-center font-weight-bold"> Nome Cliente </td>';
                $html .= '<td class="text-center font-weight-bold"> Telefone </td>';
                $html .= '<td class="text-center font-weight-bold"> Telefone 2 </td>';
                $html .= '<td class="text-center font-weight-bold"> RCA </td>';
                $html .= '<td class="text-center font-weight-bold"> Observações </td>';
                $html .= '<td class="text-center font-weight-bold"> Prazo </td>';
                $html .= '<td class="text-center font-weight-bold"> Firma no Nome? </td>';
                $html .= '<td class="text-center font-weight-bold"> Prédio Próprio </td>';
                $html .= '<td class="text-center font-weight-bold"> Status </td>';
                $html .= '<td class="text-center font-weight-bold"> Solicitante  </td>';
                $html .= '</tr>';

                $sql = $db->query("SELECT solicitacoes_prazo.*, usuarios.nome FROM solicitacoes_prazo INNER JOIN usuarios ON solicitacoes_prazo.idusuarios = usuarios.idusuarios ORDER BY data_solicitacao ASC");
                $dados = $sql->fetchAll();
                foreach($dados as $dado){
                    $html .= '<tr>';
                    $html .= '<td>' . date("d/m/Y", strtotime($dado["data_solicitacao"]))  .'</td>';
                    $html .= '<td>' . $dado['serasa'] . '</td>';
                    $html .= '<td>' . $dado['codigo_cliente'] . '</td>';
                    $html .= '<td>' . $dado['nome_cliente'] . '</td>';
                    $html .= '<td>'. $dado['fone'] .'</td>';
                    $html .= '<td>'. $dado['fone2'] .'</td>';
                    $html .= '<td>'. $dado['rca'] .'</td>';
                    $html .= '<td>'. $dado['obs'] .'</td>';
                    $html .= '<td>'. $dado['prazo_dias'] .'</td>';
                    $html .= '<td>'. $dado['firma_no_nome'] .'</td>';
                    $html .= '<td>'. $dado['predio_proprio'] .'</td>';
                    $html .= '<td>'. $dado['status_solicitacao'] .'</td>';
                    $html .= '<td>'. $dado['nome'] .'</td>';
                    $html .= '</tr>';
                    
                }
                $html .= '</table>';
                /*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: ". gmdate("D,d M YH:i:s"). "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/x-msexcel");
                header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
                header ("Content-Description: PHP Generated Data");
                echo $html;
                exit();*/
                
                //nova forma de gerar excel
                 
                // Configurações header para forçar o download  
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$arquivo.'"');
                header('Cache-Control: max-age=0');
                // Se for o IE9, isso talvez seja necessário
                header('Cache-Control: max-age=1');
                   
                // Envia o conteúdo do arquivo  
                echo $html;  
                exit;
            }
        
        ?>
    </body>
</html>