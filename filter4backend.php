<?php
include "conn.php";

$value = $_POST['check'];

$sql = "SELECT * FROM details WHERE name LIKE '$value%'";
$result = $conn->query($sql);

//print_r($result);
//die(hello);

$row = $result -> fetch_all(MYSQLI_ASSOC);

// echo "<pre>";
// print_r($row);
// echo "</pre>";

$json = json_encode( $row, true);
echo $json;





 ?>
