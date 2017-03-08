<?php

include 'Connection.php';

$connectA = new Connection('appceti.ceti.mx','cetiAppUser','Salami.239','cetiapp');


$Vistas = $connectA->enviarQuery("SELECT DISTINCT
A.MateriaId,
A.Clave,
A.Materia,
A.NivelMaestro
FROM IX_Vistas AS A
");

foreach($Vistas as $result) {
	
  $db = $connectA->enviarQuery("SELECT 
   M.codigo
   FROM materia AS M
   WHERE U.email = '".$result['Clave']."'
");

print_r($db);

if(count($db) === 0)
{
	$connectA->enviarQuery("INSERT materia(
	 codigo
	 ,nombre
	 ,nivel)
VALUES 
('".$result['Clave']."'
,'".$result['Materia']."'
,'".$result['NivelMaestro']."')");

}

}


?>