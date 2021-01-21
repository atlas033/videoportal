<?php

session_start();
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "newtube";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
?>