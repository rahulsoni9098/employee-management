<?php
include "sessionFile.php";
?>
<?php
include "conn.php";

$id = $_GET["id"];
$sql = "DELETE FROM details WHERE id = '$id' ";
$result = $conn->query($sql);

header("location:information_page.php");
?>
