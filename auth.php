<?php
  session_start();
  if (isset($_SESSION['user'])) {
    header('Location: welcome.php');
    exit;
  }

  if (isset($_POST['user']) && isset($_POST['password'])) {
    if (
      (strlen($_POST['user']) >= 4 && strlen($_POST['user']) <= 20) &&
      (strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 18)
      ) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $recordarme = isset($_POST['recordarme']);

        $cnx = mysqli_connect('localhost', 'root', 'password', 'demo')
          or die('Error en la conexión a MySQL');

        if (mysqli_connect_error()) {
          header('Location: login_error.php');
          exit();
        }
        $res = mysqli_query($cnx, "SELECT * FROM USUARIO WHERE usuario = '" . $user . "' limit 1;");
        
        while($registro = mysqli_fetch_row($res)) {
          if ($password == $registro[3]){
            $_SESSION['user'] = $user;

            header('Location: welcome.php');
            exit;
          }
        }


        header('Location: login_error.php');
        exit;
    } else {
      header('Location: login.php');
      exit;
    } 
  } else {
    header('Location: login.php');
    exit;
  }
?>
