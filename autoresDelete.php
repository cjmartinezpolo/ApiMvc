<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

 //verificar si existe el usuario
 $sql = $dbConn->prepare("SELECT * FROM autores where id= ?");
 $sql->execute([$_POST['id']]);
 $result = $sql->rowCount();

 if ($result<=0) {
    $res = array("ID ". $_POST['id'] => "no exite registro");

   echo json_encode($res);

 } else {
   
    $dato =$sql->fetch(PDO::FETCH_OBJ);

    
$id = $_POST['id'];
$statement = $dbConn->prepare("DELETE FROM autores where id=:id");
$statement->bindValue(':id', $id);
$statement->execute();
header("HTTP/1.1 200 OK");

$res = array(
    'mensaje'=> 'Registro eliminado satisfactoriamente',
    'data' => array(
        'id' =>  $dato->ID ,
        'nombres' =>  $dato->NOMBRES,
        'apellidos' =>  $dato->APELLIDOS,
        'descripcion' =>  $dato->DESCRIPCION 
    )
);
   echo json_encode($res);
   exit();
 }