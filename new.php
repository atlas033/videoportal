<?php
include("config.php");
 
if(isset($_POST['newVideo'])){
   if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ''){
       $name = $_FILES['file']['name'];
       $target_dir = "videos/";
       $target_file = $target_dir . $_FILES["file"]["name"];

       // Select file type
       $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

          // Check file size
          if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
             $_SESSION['message'] = "File too large. File must be less than 5MB.";
          }else{
             // Upload
             if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
               // Insert record
               $query = "INSERT INTO videos(name,location) VALUES('".$name."','".$target_file."')";

               mysqli_query($con,$query);
               $_SESSION['message'] = "Upload successfully.";
             }
          }

       }
       
   }else{
       $_SESSION['message'] = "Please select a file.";
   }
   header('location: index.php');
   exit;
} 
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>NewTube</title>
</head>

<body>

<?php
$conn = OpenCon();

// video variables
$titel = $dauer = $regisseur = $schauspieler = $website = "";

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
  <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" onsubmit="checkform()" enctype='multipart/form-data'>
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
      Schauspieler:
      <input type="text" name="schauspieler" value="">
    </label>
    <label>
      Video auswählen:
      <input type="file" name="video" value="Upload">
    </label>
    <button type="submit" value="Upload" name="newVideo">Video hochladen</button>
  </form>
</div>
<?php 
    if(isset($_SESSION['message_new'])){
       echo $_SESSION['message_new'];
       unset($_SESSION['message_new']);
    }
?>


<hr>

<div>
 
     <?php
     $fetchVideos = mysqli_query($con, "SELECT * FROM videos ORDER BY id DESC");
     while($row = mysqli_fetch_assoc($fetchVideos)){
       $video = $row['video'];
       $titel = $row['titel'];
       echo "<div style='float: left; margin-right: 5px;'>
          <video src='".$video."' controls width='320px' height='320px' ></video>     
          <br>
          <span>".$titel."</span>
       </div>";
     }
     CloseCon($conn);
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


<script type="text/javascript" src="script.js"></script>

</body>

</html>
