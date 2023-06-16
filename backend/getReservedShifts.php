<?php
$mysqli = new mysqli("localhost", "Usuario", "arrozz", "officebd");
mysqli_set_charset($mysqli, "utf8");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$query='SELECT fromThe as "from" , until as "to", day.day as "monthName" , date.day  ,  month ,  year  from booking 
JOIN date on (booking.id_date = date.ID)
JOIN turn on (booking.id_turn = turn.ID)
JOIN  schedule on (turn.id_schedule = schedule.ID)
JOIN day  on (turn.dayIndex=day.ID) 
WHERE date.month = ' . $_GET['month'] .  ' AND date.year = ' . $_GET['year']; 





$resultado = $mysqli->query($query);
$data = $resultado->fetch_all(MYSQLI_ASSOC);
echo json_encode($data , JSON_UNESCAPED_UNICODE );


























?>