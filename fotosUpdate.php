<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);


//verificar si existe el usuario
$sql = $dbConn->prepare("SELECT * FROM fotos where ID= ?");
$sql->execute([
    $_POST['id']
]);
$result = $sql->rowCount();

if ($result<=0) {
   $res = array("ID ". $_POST['id'] => "no exite registro");

  echo json_encode($res);

} else {
  
   $dato =$sql->fetch(PDO::FETCH_OBJ);

    $sql = "UPDATE fotos SET NOMBRE = ?,TIPO = ?,TAMAÑO = ?,DESCRIPCION = ?,FECHA_CREACION = ?,FECHA_MODIFICACION = ?,EMAIL = ?,FK_AUTORES = ?  WHERE id= ? ";

    $statement = $dbConn->prepare($sql);
    $statement->execute([
    $_POST['nombre'],
    $_POST['tipo'],
    $_POST['tamaño'],
    $_POST['descripcion'],
    $_POST['fecha_creacion'],
    $_POST['fecha_modificacion'],
    $_POST['email'],
    $_POST['fk_autores'],
    $_POST['id'],
    ]);

    header("HTTP/1.1 200 OK");

    
    //busca el los datos del fk 
    $sql1 = $dbConn->prepare("SELECT * FROM autores where id= ?");
    $sql1->execute([$_POST['fk_autores']]);

    $fk =$sql1->fetch(PDO::FETCH_OBJ);

    $res = array(
        'mensaje'=> 'Registro Actualizado satisfactoriamente',
        'data' => array(
            'id' =>  $_POST['id'] ,
            'nombre' =>  $_POST['nombre'],
            'tipo' =>  $_POST['tipo'],
            'tamaño' =>  $_POST['tamaño'], 
            'descripcion' =>  $_POST['descripcion'],
            'fecha_creacion' =>  $_POST['fecha_creacion'],
            'fecha_modificacion' =>  $_POST['fecha_modificacion'],
            'email' =>  $_POST['email'],
            "data_fk"=> array(
              'id' =>  $fk->ID ,
              'nombres' =>  $fk->NOMBRES,
              'apellidos' =>  $fk->APELLIDOS,
              'descripcion' =>  $fk->DESCRIPCION 
              )
            )
    );

echo json_encode($res);
exit();
}
