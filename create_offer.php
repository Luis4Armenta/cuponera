<?php
session_start();
if(!isset($_SESSION['user'])) {
  Header('Location: login.php');
  exit;
}

$usuario = $_SESSION['user'];
?>