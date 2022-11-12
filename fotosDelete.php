<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

 //verificar si existe el usuario
 $sql = $dbConn->prepare("SELECT * FROM fotos where ID= ?");
 $sql->execute([$_POST['id']]);
 $result = $sql->rowCount();

 if ($result<=0) {
    $res = array("ID ". $_POST['id'] => "no exite registro");

   echo json_encode($res);

 } else {
   
    $dato =$sql->fetch(PDO::FETCH_OBJ);

    //busca el los datos del fk 
    $sql1 = $dbConn->prepare("SELECT * FROM autores where id= ?");
    $sql1->execute([$dato->FK_AUTORES]);

    $fk =$sql1->fetch(PDO::FETCH_OBJ);

    
$id = $_POST['id'];
$statement = $dbConn->prepare("DELETE FROM fotos where id=:id");
$statement->bindValue(':id', $id);
$statement->execute();
header("HTTP/1.1 200 OK");

$res = array(
  'mensaje'=> 'Registro eliminado satisfactoriamente',
  'id' =>  $dato->ID ,
  'nombre' =>  $dato->NOMBRE,
  'tipo' =>  $dato->TIPO,
  'email' =>  $dato->EMAIL, 
  'tamaño' =>  $dato->TAMAÑO,
  'fecha_creacion' =>  $dato->FECHA_CREACION,
  'fecha_modificacion' =>  $dato->FECHA_MODIFICACION, 
  "data_fk"=> array(
    'id' =>  $fk->ID ,
    'nombres' =>  $fk->NOMBRES,
    'apellidos' =>  $fk->APELLIDOS,
    'descripcion' =>  $fk->DESCRIPCION 
        )
);
   echo json_encode($res);
   exit();
 }