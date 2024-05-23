<?php
session_start();

if(isset($_SESSION['user'])){
  Header('Location: welcome.php');
  exit;
}
?>
<h1>Usuario o contraseña invalidos</h1>
<a href="login.php">Regresar</a>