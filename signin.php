<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: welcome.php');
  exit;
}
?>

<?php
$title = 'Registro';
include 'shared/header.php';
?>
<style>
  .lead-with-shadow {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
</style> 
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title text-center mb-4  lead-with-shadow">Nuevo Usuario</h1>
          <form method="POST" action="create_user.php">
            <div class="form-group">
              <label for="user">Usuario</label>
              <input type="text" id="user" name="user" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="name">Nombre completo</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Enlace al archivo CSS de Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
