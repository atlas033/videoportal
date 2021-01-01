<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>NewTube</title>
</head>

<body>

<?php
include 'src.php';
$conn = OpenCon();
echo "Connected Successfully";

// video variables
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $website = test_input($_POST["website"]);
  $comment = test_input($_POST["comment"]);
  $gender = test_input($_POST["gender"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<h1>NewTube - Ihr modernes Videoportal</h1>
<p></p>

<button type="button" name="button" onclick="newVideo()">neues Video hochladen</button>

<div id="newVideoDiv" style="display: none;">
  <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="checkform()">
    <label>
      Titel:
      <input type="text" name="titel" value="">
    </label>
    <label>
      Dauer:
      <input type="time" name="dauer" value="">
    </label>
    <label>
      Schauspieler:
      <input type="text" name="schauspieler" value="">
    </label>
    <label>
      Regisseur:
      <input type="text" name="regisseur" value="">
    </label>
    <label>
      Video auswählen:
      <input type="" name="video" value="">
    </label>
    <button type="submit" name="button">Video hochladen</button>
  </form>
</div>
<?php

?>
<!-- php ; errormsg ; video auswahlen fehlt -->


<hr>

<?php

$result = $conn->query('SELECT * FROM info');
$row = $result->fetch_assoc();
echo htmlentities($row);



// Ausgabe der Ergebnisse in HTML
// echo "<table>";
// while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
//     echo "<tr>";
//     foreach ($line as $col_value) {
//         echo "<td>$col_value</td>";
//     }
//     echo "</tr>";
//     echo "<hr>";
// }
// echo "</table>";

// // Free resultset
// mysql_free_result($result);

CloseCon($conn);
?>

<!-- video titel per php und datenbank anzeigen; dauer; abspielbutton;
  neue zeile: xmlansicht button; edit button; loeschen button-->



<!-- video player + darunter alle weiteren infos-->
<!-- oder xmlansicht -->
<!-- oder form zum editieren -->
<!-- oder frage nach bestaetigung zu loeschen -->


<script type="text/javascript" src="script.js"></script>

</body>

</html>
