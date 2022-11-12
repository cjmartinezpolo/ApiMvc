<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

$input = $_POST;
$sql = "INSERT INTO autores
      (NOMBRES,APELLIDOS,DESCRIPCION) VALUES (:nombre, :apellido, :descripcion)";
$statement = $dbConn->prepare($sql);
bindAllValues($statement, $input);
$statement->execute();
$postId = $dbConn->lastInsertId();
if($postId)
{
  $input['id'] = $postId;
  header("HTTP/1.1 200 OK");
  echo json_encode($input);
  exit();
 }

