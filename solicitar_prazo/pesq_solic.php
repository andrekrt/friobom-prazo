<?php

session_start();
include 'conexao.php';
$idUsuario = $_SESSION['idUsuario'];

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " AND (serasa LIKE :serasa OR codigo_cliente LIKE :codigo_cliente OR nome_cliente LIKE :nome_cliente OR rca LIKE :rca) ";
    $searchArray = array( 
        'serasa'=>"%$searchValue%", 
        'codigo_cliente'=>"%$searchValue%",
        'nome_cliente'=>"%$searchValue%",
        'rca'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM solicitacoes_prazo");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM solicitacoes_prazo WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM solicitacoes_prazo LEFT JOIN usuarios ON solicitacoes_prazo.idusuarios = usuarios.idusuarios WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

// Bind values
foreach($searchArray as $key=>$search){
    $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

foreach($empRecords as $row){
    $data[] = array(
        "idsolicitacoes_prazo"=>$row['idsolicitacoes_prazo'],
        "data_solicitacao"=>date("d/m/Y", strtotime($row['data_solicitacao'])),
        "serasa"=>$row['serasa'],
        "codigo_cliente"=>$row['codigo_cliente'],
        "nome_cliente"=>utf8_encode(utf8_decode($row['nome_cliente'])) ,
        "fone"=>$row['fone'] ,
        "rca"=>$row['rca'],
        "obs"=>$row['obs'],
        "anexos"=>' <a target="_blank" href="uploads/'.$row['idsolicitacoes_prazo'].'">Anexos</a> ',
        "prazo_dias"=>$row['prazo_dias'] . " Dias",
        "status_solicitacao"=>utf8_encode(utf8_decode($row['status_solicitacao'])),
        "solicitante"=>utf8_encode(utf8_decode($row['nome'])),
        "acoes"=> '<a href="javascript:void();" data-id="'.$row['idsolicitacoes_prazo'].'"  class="btn btn-info btn-sm editbtn" >Detalhes</a> '
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
