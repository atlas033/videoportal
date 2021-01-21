<?php
include("config.php");

$id = $_GET['id'];

$fetchVideo = mysqli_query($conn, "SELECT video FROM videos WHERE id=$id");
$row = mysqli_fetch_assoc($fetchVideo);
$conn->close();

header("Content-type: video/mp4");
echo $row['video'];
?>
