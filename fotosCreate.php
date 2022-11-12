<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

$input = $_POST;

$sql = "INSERT INTO fotos
      (NOMBRE,TIPO,TAMAÑO,DESCRIPCION,FECHA_CREACION,FECHA_MODIFICACION,EMAIL,FK_AUTORES) VALUES (:nombre, :tipo, :tamano, :descripcion, :fecha_creacion, :fecha_modificacion, :email, :fk_autores)";
$statement = $dbConn->prepare($sql);
bindAllValues($statement, $input);
$statement->execute();
$postId = $dbConn->lastInsertId();

//buscamos los campos del registro insertado
$sql = $dbConn->prepare("SELECT * FROM fotos where id= ?");
$sql->execute([$postId]);
$dato = $sql->fetch(PDO::FETCH_OBJ);

 //busca el los datos del fk 
 $sql1 = $dbConn->prepare("SELECT * FROM autores where id= ?");
 $sql1->execute([$dato->FK_AUTORES]);

 $fk =$sql1->fetch(PDO::FETCH_OBJ);

 $res =  array(
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

header("HTTP/1.1 200 OK");
echo json_encode($res);


