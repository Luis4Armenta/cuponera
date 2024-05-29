<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: welcome.php');
  exit;
}
?>

<?php
$title = 'Registrarme';
// $extra_styles = ['two.css', 'one.css'];
include 'shared/header.php';
?>

<div>
  <h1>Registrarme</h1>
  <form method="POST" ACTION="create_user.php">
    <label for="user">Usuario</label>
    <input type="text" id="user" name="user" />
    <br />
    <label for="name">Nombre completo</label>
    <input type="text" id="name" name="name" />
    <br />
    <label for="password">Contraseña</label>
    <input type="password" id="password" name="password" />
    <br />

    <input type="submit" value="¡Registrarse!" />
  </form>
</div>