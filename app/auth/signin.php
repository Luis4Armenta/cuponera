<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: ../index.php');
  exit;
}
?>

<?php
$title = 'Registro';
include '../shared/header.php';
?>
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title text-center mb-4  lead-with-shadow">Nuevo Usuario</h1>
          <form method="POST" action="/auth/actions/create_user.php">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="user">Usuario</label>
              <input type="text" id="user" name="user" class="form-control" required minlength="4" maxlength="20" >
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" required minlength="8" maxlength="16">
            </div>
            <p>Si ya tienes una cuenta puede ingresar <a href="/auth/login.php">aquí</a></p>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg">Registrarse</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../shared/footer.php'; ?>