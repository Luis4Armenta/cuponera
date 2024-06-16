<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: ../welcome.php');
  exit;
}
?>

<?php
$title = 'Login';
include '../shared/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <div class="card-header text-center">
                    <h1 class="fs-1">Login</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="actions/auth.php">
                        <div class="form-group">
                            <label for="user">Usuario</label>
                            <input type="text" class="form-control" id="user" name="user" required minlength="4" maxlength="20" placeholder="usuario"/>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="16" placeholder="contraseña"/>
                        </div>
                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="recordarme" name="recordarme" value="NO"/>
                            <label class="form-check-label" for="recordarme">Recordarme</label>
                        </div>
                        <p class="mt-3">No tengo una cuenta, quiero <a href="./signin.php">registrarme</a></p>
                        <div class="d-grid">
                            <input type="submit" value="Ingresar" class="btn btn-primary"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../shared/footer.php'; ?>
