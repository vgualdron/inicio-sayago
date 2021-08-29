<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
require_once("../conexion.php");
require_once("../encrypted.php");
$conexion = new Conexion();

$frm = json_decode(file_get_contents('php://input'), true);

echo "2::".print_r($frm)."<br>";

$usuario = $frm['cuenta'];
$clave = $frm['clave'];
$date = date("Y-m-d H:i:s");

$use = $conexion->prepare("select bd_general.autenticacion (?, ?, ?) as usua_id;");

$use->bindValue(1, $usuario);
$use->bindValue(2, $clave);
$use->bindValue(3, $date);
	
$use ->execute();
$count = $use->rowCount();
$row = $use->fetchAll();
$data = (object) array();
$idusuario = 0;
foreach($row as $registro){
	$idusuario = $registro['usua_id'];
	$_SESSION['idUsuario'] =  $idusuario;
}
$data->token = $idusuario > 0 ? openCypher('encrypt', $_SESSION['idUsuario']) : null;
$data->estado = $idusuario > 0 ? "OK" : "ERROR";
$data->mensaje = $idusuario > 0 ? "Bienvenido" : "Usuario o clave incorrecta.";


print_r(json_encode($data));
?>