<?php

session_start();
include 'conexao.php';

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
	$searchQuery = " AND (nome LIKE :nome OR email LIKE :email) ";
    $searchArray = array( 
        'nome'=>"%$searchValue%", 
        'email'=>"%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM usuarios WHERE idtipo_usuario = 2");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM usuarios WHERE 1 AND idtipo_usuario = 2 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $db->prepare("SELECT * FROM usuarios WHERE 1 AND idtipo_usuario = 2 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
        "idusuarios"=>$row['idusuarios'],
        "nome"=>utf8_encode(utf8_decode($row['nome'])) ,
        "email"=>$row['email'],
        "acoes"=> '<a href="javascript:void();" data-id="'.$row['idusuarios'].'"  class="btn btn-info btn-sm editbtn" >Detalhes</a>  '
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
