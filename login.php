<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: welcome.php');
  exit;
}
?>

<?php
$title = 'Login';
// $extra_styles = ['two.css', 'one.css'];
include 'shared/header.php';
?>

  <div class="container">
    <div class="login-form">
      <div class="login-form-head">
        <h1>Login</h1>
      </div>
      <div class="login-form-body">
        <form method="POST" action="auth.php">
          <label for="user">Usuario</label>
          <input type="text" id="user" name="user" required minlength="4" maxlength="20" placeholder="usuario"/>
          <br />
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required minlength="8" maxlength="16" placeholder="contraseña"/>
          <br />
          <label for="recordarme">Recordarme</label>
          <input type="checkbox" id="recordarme" name="recordarme" value="NO"/>
          <br />
          <input type="submit" value="Ingresar" class="btn" />
        </form>
      </div>
    </div>
  </div>

<?php include 'shared/footer.php'; ?>