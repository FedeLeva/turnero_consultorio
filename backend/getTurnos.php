<?php
$mysqli = new mysqli("localhost", "Usuario", "arrozz", "consultoriobd");
mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$query='SELECT desde,hasta, dia as nombre_dia , date as dia , mes , año  from reserva 
JOIN fecha on (reserva.id_fecha = fecha.ID)
JOIN turno on (reserva.id_turno = turno.ID)
JOIN horario on (turno.id_horario = horario.ID)
JOIN dia on (turno.indice_dia=dia.ID) WHERE fecha.mes = ' . $_GET['month'] .  ' AND fecha.año = ' . $_GET['year']; 
$resultado = $mysqli->query($query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);
echo json_encode($data , JSON_UNESCAPED_UNICODE );


























?>