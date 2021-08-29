<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

include "../config.php";
include "../utils.php";

$conexion = connect($db);

$frm = json_decode(file_get_contents('php://input'), true);

$usuario = $frm['cuenta'];
$clave = $frm['clave'];

echo "1 ::".print_r($frm)."<br>";
//echo "2 ::".$usuario."<br>";
//echo "3 ::".$clave."<br>";

//  listar todos los posts o solo uno
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($frm['cuenta']) && isset($frm['clave'])) {
      //Mostrar un post
      $sql = $conexion->prepare("SELECT * FROM bd_general.usuario usua 
                                where usua.usua_cuenta=:cuenta 
                                and usua.usua_clave=:clave; ");
                                
      $sql->bindValue(':cuenta', $frm['cuenta']);
      $sql->bindValue(':clave', $frm['clave']);
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
        echo json_encode($result);
        exit();
      }
	  }
    else {
      //error
      $data = (object) array();
      $data->mensaje = "Usuario o clave no ingresado.";
      header("HTTP/1.1 400 Bad Request");
      echo json_encode( $data );
      exit();
	  }
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>