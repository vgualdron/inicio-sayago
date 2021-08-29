<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

require_once("../conexion.php");
require_once("../encrypted.php");

$conexion = new Conexion();

$frm = json_decode(file_get_contents('php://input'), true);

$usuario = $frm['cuenta'];
$clave = $frm['clave'];
$date = date("Y-m-d H:i:s");

if (isset($frm['cuenta']) && isset($frm['clave'])) {
  //Mostrar un post
  $sql = $conexion->prepare("SELECT * FROM pinchetas_general.usuario usua 
                            where usua.usua_cuenta= ? 
                            and usua.usua_clave= ?; ");
                  
  $sql->bindValue(1, $frm['cuenta']);
  $sql->bindValue(2, $frm['clave']);
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
    $data->token = openCypher('encrypt', $result["pege_id"]);
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