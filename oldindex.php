<?php
include("config.php");

if(isset($_POST['newVideo'])){
  if(!isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''){
    $_SESSION['message_new'] = "Video fehlt.";
  }  
  else if (!isset($_POST['titel'])){
    $_SESSION['message_new'] = "Titel fehlt.";
  } 
  else {
    $target_file = $_FILES["video"]["name"];

    if(move_uploaded_file($_FILES['video']['tmp_name'],$target_file)){
      $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          
      $query = "INSERT INTO videos(titel, dauer, regisseur, video, videoformat) VALUES('".$_POST['titel']."','".$_POST['dauer']."','".$_POST['regisseur']."','".$target_filer."','".$extension."')";

      mysqli_query($conn,$query);
      $_SESSION['message_new'] = "Hochladen erfolgreich.";
      unlink($target_file);
    }
  }
}

if(isset($_POST['delete'])){
  $_SESSION['message_del']= 'Eintrag gelöscht.';
}

if(isset($_POST['edit'])){
  $_SESSION['message_edit'] = 'Eintrage geändert.';
}



if (count($_POST) > 0) {
    foreach ($_POST as $k=>$v) {
        unset($_POST[$k]);
    }
  }
  
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

<?php 
  if(isset($_SESSION['message_new'])){
       echo $_SESSION['message_new'];
       unset($_SESSION['message_new']);
    }
  if(isset($_SESSION['message_del'])){
      echo $_SESSION['message_del'];
      unset($_SESSION['message_del']);
  }
  if(isset($_SESSION['message_edit'])){
  echo $_SESSION['message_edit'];
  unset($_SESSION['message_edit']);
  }
?>

<br>

<!-- neues video -->

<button type="button" name="button" onclick="newVideo()">neues Video hochladen</button>

<div id="newVideoDiv" style="display: none;">
  <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="" enctype='multipart/form-data'>
    <label>
      Titel:
      <input type="text" name="titel" value="">
    </label>
    <label>
      Dauer:
      <input type="time" name="dauer" value="">
    </label>
    <label>
      Regisseur:
      <input type="text" name="regisseur" value="">
    </label>
    <label>
      Video auswählen:
      <input type="file" name="video" value="Upload">
    </label>
    <input type="submit" value="Upload" name="newVideo">Video hochladen</input>
  </form>
</div>


<!-- video ansicht -->

<div>
 
  <?php
  $fetchVideos = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
  while($row = mysqli_fetch_assoc($fetchVideos)){
    $video = $row['video'];
    $titel = $row['titel'];
    echo "<div style='float: left; margin-right: 5px;'>
      <hr>
      <video src='".$video."' controls width='320px' height='320px' ></video>     
      <br>
      <p>".$titel."</p>

      <form action='oldindex.php' method='post' enctype=''>
        <input type='submit' value='Bearbeiten' name='edit'></input>
      </form>

      <form action='oldindex.php' method='post' enctype=''>
        <input type='submit' value='Löschen' name='delete'></input>
      </form>

      <form action='oldindex.php' method='post' enctype=''>
        <input type='submit' value='XML Ansicht' name='xml'></input>
      </form>     
      

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
  $conn-> close();
?>
</body>

</html>
