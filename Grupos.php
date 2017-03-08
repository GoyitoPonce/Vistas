<?php

include 'Connection.php';

$connectA = new Connection('appceti.ceti.mx','cetiAppUser','Salami.239','cetiapp');

$Vistas = $connectA->enviarQuery("SELECT DISTINCT
A.NombreGrupo,
A.Semestre,
A.NivelAlumno,
A.Carrera,
A.Turno
FROM IX_Vistas AS A
");

foreach($Vistas as $result) {
	
  $db = $connectA->enviarQuery("SELECT 
   U.nombre
   FROM grupos AS U
   WHERE U.email = '".$result['NombreGrupo']."'
");
print_r($db);

if(count($db) === 0)
{
	$connectA->enviarQuery("INSERT grupos(
	  nombre
	 ,semestre
	 ,nivel
	 ,carrera_division
	 ,tipo
	 ,turno)
VALUES 
('".$result['NombreGrupo']."'
,'".$result['Semestre']."'
,'".$result['NivelAlumno']."'
,'".$result['Carrera']."'
,'Estudiantes'
,'".$result['Turno']."')");

}

}


?>