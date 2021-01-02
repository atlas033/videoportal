<?php
 
$servername = "localhost";
$username = "root";
$password = "1234";
$db = "newtube";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
  die("Fehler bei der Verbindung: " . $conn->connect_error);
}

// Database erstellen
// $sql = "CREATE DATABASE newtube";
// if ($conn->query($sql) === TRUE) {
//   echo "Database newtube erfolgreich erstellt";
// } else {
//   echo "Fehler beim Erstellen der Database: " . $conn->error;
// }

// Tabelle erstellen
$sql = "CREATE TABLE videos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titel VARCHAR(50) NOT NULL,
    dauer TIME NOT NULL,
    regisseur VARCHAR(50),
    schauspieler VARCHAR(255),
    video LONGBLOB,
    videoformat VARCHAR(3) NOT NULL
    );";

if ($conn->query($sql) === TRUE) {
    echo "Tabelle videos erfolgreich erstellt<br></br>";
} else {
    echo "Fehler beim Erstellen der Tabelle: " . $conn->error;
}

// Tabellen Einträge machen
$sql = "INSERT INTO videos (titel, dauer, regisseur, schauspieler, videoformat)
VALUES ('bigcat', time('00:00:02'), 'Harald', '', 'avi');";
$sql .= "INSERT INTO videos (titel, dauer, regisseur, schauspieler, videoformat)
VALUES ('popcat', time('00:00:10'), '', 'popcat', 'mp4');";
$sql .= "INSERT INTO videos (titel, dauer, regisseur, schauspieler, videoformat)
VALUES ('talking cats', time('00:00:55'), 'Anton', 'Findus, Daisy', 'mp4');";

if ($conn->query($sql) === TRUE) {
    echo "Einträge erfolgreich erstellt<br></br>";
} else {
    echo "Fehler beim Erstellen der Einträge: " . $conn->error;
}

$conn->close();

?>