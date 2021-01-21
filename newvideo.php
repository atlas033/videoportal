<?php
include("config.php");
 
if(!isset($_POST['newVideo'])){
  $_SESSION['message'] = "Video fehlt.";
} 
else if (!isset($_POST['titel'])){
  $_SESSION['message'] = "Titel fehlt.";
} 
else if(isset($_FILES['video']['name']) && $_FILES['video']['name'] != '')
{
  $target_file = $_FILES["video"]["name"];

  if(move_uploaded_file($_FILES['video']['tmp_name'],$target_file)){
    $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     
    $query = "INSERT INTO videos(titel, dauer, regisseur, video, videoformat) VALUES('".$_POST['titel']."','".$_POST['dauer']."','".$_POST['regisseur']."','".$target_file."','".$extension."')";

    mysqli_query($conn,$query);
    $_SESSION['message'] = "Upload successfully.";
    unlink($target_file);
}
}
   header('location: newvideo.php');
   exit;
 
?>


<!doctype html> 
<html> 
  <head>
     <title>NewTube</title>
  </head>
  <body>

    <h1>NewTube - Ihr modernes Videoportal</h1>
<p></p>


<!-- neues video -->

<h3>Neues Video hochladen</h3>

<div id="newVideoDiv">
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
<?php 
    if(isset($_SESSION['message'])){
       echo $_SESSION['message'];
       unset($_SESSION['message']);
    }
?>
    
   <p><a href="index.php">Videos anschauen</a></p>
  </body>
</html>