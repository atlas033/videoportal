<?php
include("config.php");

if(isset($_POST['newVideo'])){
  if(!isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''){
    $_SESSION['message'] = "Video fehlt.";
  }  
  else if (!isset($_POST['titel'])){
    $_SESSION['message'] = "Titel fehlt.";
  } 
  else {

    $extension = strtolower(pathinfo($_FILES['video']['name'],PATHINFO_EXTENSION));
    
    
    $vid = file_get_contents($_FILES['video']['tmp_name']);
    $vid = mysqli_real_escape_string($conn, $vid);
    
    $query = "INSERT INTO videos(titel, erstellungsdatum, regisseur, video, videoformat) VALUES('".$_POST['titel']."','".$_POST['erstellungsdatum']."','".$_POST['regisseur']."','".$vid."','".$extension."');";

    mysqli_query($conn, $query);
    $_SESSION['message'] = "Hochladen erfolgreich.". mysqli_error($conn);
    
    if (count($_POST) > 0) {
      foreach ($_POST as $k=>$v) {
          unset($_POST[$k]);
      }
    }
    
    header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
    exit();
  }
}


if(isset($_POST['delete'])){
  
  mysqli_query($conn, "DELETE FROM videos WHERE id='". htmlspecialchars($_POST['id'])."'" );

  $_SESSION['message']= "Eintrag gelöscht.";

  unset($_POST['delete']);
  unset($_POST['id']);

  header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
  exit();
}


if(isset($_POST['editVideo'])){
  if(isset($_POST['titel']) && $_POST['titel'] != ''){
    $query="UPDATE videos SET titel='".$_POST['titel']."', erstellungsdatum='".$_POST['erstellungsdatum']."', regisseur='".$_POST['regisseur']."' WHERE ID=".$_POST['id'].";";
  }else{
    $query="UPDATE videos SET erstellungsdatum='".$_POST['erstellungsdatum']."', regisseur='".$_POST['regisseur']."' WHERE ID=".$_POST['id'].";";
  }
  mysqli_query($conn, $query);

  $_SESSION['message'] = 'Eintrag geändert.';

  if (count($_POST) > 0) {
    foreach ($_POST as $k=>$v) {
        unset($_POST[$k]);
    }
  }
  
  header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
  exit();
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
  if(isset($_SESSION['message'])){
       echo $_SESSION['message'];
       unset($_SESSION['message']);
    }
?>
<p></p>
<br>

<!-- neues video -->

<button type="button" name="button" onclick="newVideo()">neues Video hochladen</button>

<div id="newVideoDiv" style="display: none;">
  <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="" enctype='multipart/form-data'>
    <label>
      <input type="text" name="titel" placeholder="Titel eingeben">
    </label>
    <label>
      <input type="date" name="erstellungsdatum" value="">
    </label>
    <label>
      <input type="text" name="regisseur" placeholder="Regisseur eingeben">
    </label>
    <label>
      <input type="file" name="video" value="Upload">
    </label>
    <input type="submit" value="Video hochladen" name="newVideo"></input>
  </form>
</div>


<!-- video bearbeiten -->

<?php
if(isset($_POST['edit'])){
  $fetchVideos = mysqli_query($conn, "SELECT * FROM videos WHERE id='". htmlspecialchars($_POST['id'])."'");
  $row = mysqli_fetch_assoc($fetchVideos);
  
  echo '<div id="editVideoDiv">
  <hr>
  <p>Bearbeiten der Videodetails</p>
  <form class="" action="index.php" method="post">
  <input type="hidden" name="id" value="'.htmlspecialchars($_POST['id']).'">
    <label>
      Titel:
      <input type="text" value="'.$row["titel"].'" name="titel">
    </label>
    <label>
      Erstellungsdatum:
      <input type="date" value="'.$row["erstellungsdatum"].'" name="erstellungsdatum">
    </label>
    <label>
      Regisseur:
      <input type="text" value="'.$row["regisseur"].'" name="regisseur">
    </label>
    <input type="submit" value="bearbeiten" name="editVideo"></input>
  </form>
  </div>';

  unset($_POST['edit']);
  unset($_POST['id']);
}
?>


<!-- video xml ansicht -->

<?php
  if(isset($_POST['xml'])){
    $fetchVideos = mysqli_query($conn, "SELECT * FROM videos WHERE id=" .$_POST['id']);
    $row = mysqli_fetch_assoc($fetchVideos);

    $doc = new DOMDocument('1.0');

    $doc->formatOutput = true;

    $root = $doc->createElement('videoeintrag');
    $root = $doc->appendChild($root);

    $property = $doc->createElement('id');
    $property = $root->appendChild($property);

    $text = $doc->createTextNode($row['id']);
    $text = $property->appendChild($text);

    $property = $doc->createElement('titel');
    $property = $root->appendChild($property);

    $text = $doc->createTextNode($row['titel']);
    $text = $property->appendChild($text);

    $property = $doc->createElement('erstellungsdatum');
    $property = $root->appendChild($property);

    $text = $doc->createTextNode($row['erstellungsdatum']);
    $text = $property->appendChild($text);

    $property = $doc->createElement('regisseur');
    $property = $root->appendChild($property);

    $text = $doc->createTextNode($row['regisseur']);
    $text = $property->appendChild($text);

    $property = $doc->createElement('videoformat');
    $property = $root->appendChild($property);

    $text = $doc->createTextNode($row['videoformat']);
    $text = $property->appendChild($text);


    echo "<hr><p>XML-Ansicht des Eintrags</p><div> <pre> <code>";
    echo htmlspecialchars($doc->saveXML());
    echo "</code> </pre> </div>";

    unset($_POST['xml']);
    unset($_POST['id']);
  }
?>


<!-- video ansicht -->

<div>
 
  <?php
  $fetchVideos = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
  while($row = mysqli_fetch_assoc($fetchVideos)){
    $id = $row['id'];
    $video = $row['video'];
    $titel = $row['titel'];
    $format = $row['videoformat'];
    echo "<div style='float: left; margin-right: 5px;'>
      <hr>
      <video src='getVideo.php?id=".$id."' controls width='320px' height='320px' >
      <p>Your browser cannot play the provided video file.</p>
      </video>     
      <br>
      <p>".$titel."</p>

      <form action='index.php' method='post'>
        <input type='hidden' name='id' value='".$id."'>
        <input type='submit' value='Bearbeiten' name='edit'></input>
      </form> 
      
      <form action='index.php' method='post'>
        <input type='hidden' name='id' value='".$id."'>
         <input type='submit' value='Löschen' name='delete'></input>
      </form>

      <form action='index.php' method='post'>
        <input type='hidden' name='id' value='".$id."'>
        <input type='submit' value='XML Ansicht' name='xml'></input>
      </form>     
    
      </div>";
  }

     
  ?>
 
</div>


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
