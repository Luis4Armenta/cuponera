<?php
session_start();

if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}

include 'shared/header.php';
?>

  <div class="container">
    <div class="">⚠️</div>
    <h1 class="">Usuario o contraseña inválidos</h1>
    <p class="">Por favor, verifica tus credenciales e intenta de nuevo.</p>
    <a href="login.php" class="btn btn-primary">Regresar</a>
  </div>

<?php include 'shared/footer.php'; ?>