<?php
include "php/config.php";
$id = $_GET["id"];
$sql = "DELETE FROM `patients` WHERE id = $id";
$result = mysqli_query($con, $sql);

if ($result) {
  header("Location: patient-registered.php?msg=Data deleted successfully");
} else {
  echo "Failed: " . mysqli_error($conn);
}