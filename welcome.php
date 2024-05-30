<?php
session_start();
if(!isset($_SESSION['user'])) {
  Header('Location: login.php');
  exit;
}

$usuario = $_SESSION['user'];

?>

<?php
$title = 'Welcome';
include 'shared/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title mb-4">Bienvenido <?php echo $usuario ?></h1>
          <form action="logout.php" method="post">
            <button type="submit" class="btn btn-primary">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<?php include 'shared/footer.php'; ?>
