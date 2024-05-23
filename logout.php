<?php
session_start();
if(!isset($_SESSION['user'])) {
  Header('Location: login.php');
  exit;
}

session_unset();
session_destroy();
Header('Location: login.php');
?>