<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

require_once("../conexion.php");
require_once("../encrypted.php");

$conexion = new Conexion();

$frm = json_decode(file_get_contents('php://input'), true);

$id = $frm['token'];
$date = date("Y-m-d H:i:s");

if (isset($frm['token'])) {
  //Mostrar un post
  $sql = $conexion->prepare("SELECT * FROM bd_general.usuario usua 
                            where usua.usua_id=? ; ");
                  
  $sql->bindValue(1, openCypher('decrypt', $frm['token']));
  $sql->execute();
  header("HTTP/1.1 200 OK");
  $result = $sql->fetch(PDO::FETCH_ASSOC);
  if ($result == false) {
    $data = (object) array();
    $data->mensaje = "Usuario o clave incorrecta.";
    header("HTTP/1.1 400 Bad Request");
    echo json_encode( $data );
    exit();
  } else {
    $_SESSION["idUsuario"] = $result["usua_id"];
    $data = (object) array();
    $data->mensaje = "Bienvenido, ".$result["usua_cuenta"];
    $data->token = openCypher('encrypt', $result["usua_id"]);
    echo json_encode($data);
    exit();
  }
}
else {
  //error
  $data = (object) array();
  $data->mensaje = "Usuario o clave no ingresado.";
  // header("HTTP/1.1 400 Bad Request");
  echo json_encode( $data );
  // exit();
}


?>