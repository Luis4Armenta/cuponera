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

<h1>
  Bienvenido <?php echo $usuario ?>
  <form action="logout.php" method="post" >
    <input type="submit" value="LogOut" />
  </form>
</h1>

<?php include 'shared/footer.php'; ?>