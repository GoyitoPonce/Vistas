<?php
include 'Connection.php';
include 'Help.php';

$connectA = new Connection('appceti.ceti.mx','cetiAppUser','Salami.239','cetiapp');
$connectV = new Connection('192.168.2.58','appceti_u','fb047f29b91cf','calculo');
$help = new Help();

//select que trae todos los datos de la vista
$sql = $connectV->enviarQuery("SELECT 
A.nombre_completo,
SUBSTRING_INDEX(SUBSTRING_INDEX(A.correo,'@','1'),'a','-1') AS Registro,
A.correo,
A.NombreGrupo, 
A.Semestre, 
A.Nivel, 
A.Turno, 
A.Nombre,
M.materiaId,
MH.clave,
MH.materia,
MH.dia,
MH.hora,
MH.grupo,
MA.nombre as maestro,
MA.correoInstitucional,
MA.nivel,
MA.division,
T.registro
FROM alumnos_app AS A
INNER JOIN alumnos_materias_app as M ON M.registro = SUBSTRING_INDEX(SUBSTRING_INDEX(A.correo,  '@',  '1' ), 'a','-1')
INNER JOIN horas_materias_app as MH ON MH.id = M.materiaId
INNER JOIN maestros_app as MA ON MA.id = MH.maestro_id
LEFT JOIN tutores as T ON T.idMaestro = MA.id");

$connectA->enviarQuery("Truncate IX_Vistas");

foreach($sql as $result) {
$connectA->enviarQuery("INSERT IX_Vistas(
	 nombre_completo
	,RegistroAlumno
	,correo
	,NombreGrupo
	,Semestre
	,NivelAlumno
	,Turno
	,Carrera
	,MateriaId
	,Clave
	,Materia
	,Dia
	,Hora
	,GrupoM
	,Maestro
	,CorreoMaestro
	,NivelMaestro
	,Division
	,tutor)
VALUES 
('".utf8_encode($result['nombre_completo'])."'
,'".$result['Registro']."'
,'".$result['correo']."'
,'".$result['NombreGrupo']."'
,'".$result['Semestre']."'
,'".$result['Nivel']."'
,'".$result['Turno']."'
,'".$result['Nombre']."'
,'".$result['materiaId']."'
,'".$result['clave']."'
,'".$result['materia']."'
,'".$result['dia']."'
,'".$result['hora']."'
,'".$result['grupo']."'
,'".$result['maestro']."'
,'".$result['correoInstitucional']."'
,'".$result['nivel']."'
,'".$result['division']."'
,'".$result['registro']."')");

}
?>