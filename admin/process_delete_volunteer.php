<?php
include 'db.php';

$id = $_POST['id'];

$query = "DELETE FROM volunteers WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
echo "success";
?>
