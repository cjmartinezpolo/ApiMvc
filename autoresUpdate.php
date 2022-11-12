<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

//verificar si existe el usuario
$sql = $dbConn->prepare("SELECT * FROM autores where ID= ?");
$sql->execute([
    $_POST['id']
]);
$result = $sql->rowCount();

if ($result<=0) {
   $res = array("ID ". $_POST['id'] => "no exite registro");

  echo json_encode($res);

} else {
  
   $dato =$sql->fetch(PDO::FETCH_OBJ);

    $sql = "UPDATE autores SET NOMBRES= ? , APELLIDOS = ? , DESCRIPCION = ?  WHERE id= ? ";

    $statement = $dbConn->prepare($sql);
    $statement->execute([
    $_POST['nombres'],
    $_POST['apellidos'],
    $_POST['descripcion'],
    $_POST['id'],
    ]);

    header("HTTP/1.1 200 OK");

    $res = array(
        'mensaje'=> 'Registro actualizado satisfactoriamente',
        'data' => array(
            'id' =>  $_POST['id'] ,
            'nombres' =>  $_POST['nombres'],
            'apellidos' =>  $_POST['apellidos'],
            'descripcion' =>  $_POST['descripcion'] 
        )
    );

echo json_encode($res);
exit();
}
