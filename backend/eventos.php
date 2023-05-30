<?php



$mysqli = new mysqli("localhost", "Usuario", "arrozz", "consultoriobd");

mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}




$query = "SELECT * FROM fecha " ;
if (isset($_GET['mes'])) {
    $query = $query . " where mes = " . $_GET['mes'] . " AND turnos_disponibles = 0";
}




$resultado = $mysqli->query( $query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);

echo json_encode($data , JSON_UNESCAPED_UNICODE )



?>