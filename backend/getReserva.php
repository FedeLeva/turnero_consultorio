<?php



$mysqli = new mysqli("localhost", "Usuario", "arrozz", "consultoriobd");

mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}




$query = "SELECT * FROM reserva  
join paciente as p on reserva.id_paciente = p.ID 
join fecha as f on reserva.id_fecha = f.ID 
join turno on  reserva.id_turno = turno.ID 
join horario on turno.id_horario = horario.ID
";




if (isset($_GET['id'])) {
    $query = $query . " where MP_identificador = " . $_GET['id'];
}





$resultado = $mysqli->query( $query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);

echo json_encode($data , JSON_UNESCAPED_UNICODE )



?>