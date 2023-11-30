<?php
include "php/config.php";
$id = $_GET["id"];
$sql = "DELETE FROM `appointment` WHERE id = $id";
$result = mysqli_query($con, $sql);

if ($result) {
  header("Location: appointment-records.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($conn);
}