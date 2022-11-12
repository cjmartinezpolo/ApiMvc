<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

//Mostrar lista de post
$sql = $dbConn->prepare("SELECT * FROM autores");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
header("HTTP/1.1 200 OK");
echo json_encode( $sql->fetchAll()  );
exit();
