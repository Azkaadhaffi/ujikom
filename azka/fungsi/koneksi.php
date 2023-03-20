<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "app_laundry";
// Create connection
$koneksi = new mysqli($servername, $username, $password, $db);

// Check connection
if ($koneksi->connect_error) {
  die("Connection failed: " . $koneksi->connect_error);
}
