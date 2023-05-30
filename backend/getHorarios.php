
<?php
$mysqli = new mysqli("localhost", "Usuario", "arrozz", "consultoriobd");
mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$query='SELECT desde,hasta,dia , indice_dia from turno 
JOIN horario on (turno.id_horario = horario.ID)
JOIN dia on (turno.indice_dia = dia.ID)';
$resultado = $mysqli->query($query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);
echo json_encode($data , JSON_UNESCAPED_UNICODE );

