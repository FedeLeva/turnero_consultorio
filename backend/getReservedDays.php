<?php



$mysqli = new mysqli("localhost", "Usuario", "arrozz", "officebd");
mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}




$query = "SELECT * FROM date " ;
if (isset($_GET['month'])) {
    $query = $query . " where month = " . $_GET['month'] . " AND shifts_available = 0";
}




$resultado = $mysqli->query( $query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);

echo json_encode($data , JSON_UNESCAPED_UNICODE )



?>