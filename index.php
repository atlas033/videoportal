<?php
include("config.php");

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>NewTube</title>
</head>

<body>

<h1>NewTube - Ihr modernes Videoportal</h1>
<p></p>


<!-- neues video -->

<form method="get" action="newvideo.php">
    <button type="submit">neue Videos hochladen</button>
</form>


<hr>

<!-- video ansicht -->

<div>
 
  <?php
  $fetchVideos = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
  while($row = mysqli_fetch_assoc($fetchVideos)){
    $video = $row['video'];
    $titel = $row['titel'];
    echo "<div style='float: left; margin-right: 5px;'>
      <video src='".$video."' controls width='320px' height='320px' ></video>     
      <span>".$titel."</span>
      <button type='button' name='button' onclick=''>Bearbeiten</button>
      <button type='button' name='button' onclick=''>Löschen</button>
      <button type='button' name='button' onclick=''>XML Ansicht</button>
      <br>
      </div>";
  }
     
  ?>
 
</div>

<!-- // Ausgabe der Ergebnisse in HTML
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
// mysql_free_result($result); -->




<!-- video titel per php und datenbank anzeigen; dauer; abspielbutton;
  neue zeile: xmlansicht button; edit button; loeschen button-->



<!-- video player + darunter alle weiteren infos-->
<!-- oder xmlansicht -->
<!-- oder form zum editieren -->
<!-- oder frage nach bestaetigung zu loeschen -->


<script type="text/javascript">
function newVideo(){
    var x = document.getElementById("newVideoDiv");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
</script>


<?php
  // $conn-> close();
?>
</body>

</html>
