<?php



$mysqli = new mysqli("localhost", "Usuario", "arrozz", "officebd");
mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}




$query = "SELECT * FROM booking
join patient as p on booking.id_patient = p.ID 
join date as d on booking.id_date = d.ID 
join turn as t on  booking.id_turn = t.ID 
join schedule as s on t.id_schedule = s.ID
";





if (isset($_GET['id'])) {
    $query = $query . " where MP_identifier = " . $_GET['id'];
}





$resultado = $mysqli->query( $query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);

echo json_encode($data , JSON_UNESCAPED_UNICODE )



?>