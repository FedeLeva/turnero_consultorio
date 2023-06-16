<?php
$mysqli = new mysqli("localhost", "Usuario", "arrozz", "officebd");
mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$query = 'select * from  coupon 
WHERE code = ' . "'"  . $_GET['id'] . "'";
$resultado = $mysqli->query( $query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);

echo json_encode($data , JSON_UNESCAPED_UNICODE )
?>