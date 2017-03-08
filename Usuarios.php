<?php

include 'Connection.php';
include 'Help.php';

$connectA = new Connection('appceti.ceti.mx','cetiAppUser','Salami.239','cetiapp');
$help = new Help();

$Vistas = $connectA->enviarQuery("SELECT DISTINCT
A.correo,
A.nombre_completo
FROM IX_Vistas AS A
");

foreach($Vistas as $result) {
	
  $db = $connectA->enviarQuery("SELECT 
   U.email
   U.NombreCompleto
   FROM usuarios AS U
   WHERE U.email = '".$result['correo']."'
");
//genero el paswordd
$password = $help->GeneratePassword();
print_r($db);

if(count($db) === 0)
{
	$connectA->enviarQuery("INSERT usuarios(
	 email
	 ,nombre
	 ,password
	 ,rol_id)
VALUES 
('".$result['correo']."'
,'".$result['nombre_completo']."'
,'".$password."'
,'1')");

}

}


?>