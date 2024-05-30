<?php
  session_start();
  if (isset($_SESSION['user'])) {
    header('Location: welcome.php');
    exit;
  }

  if (isset($_POST['user']) && isset($_POST['name']) && isset($_POST['password'])) {
    if (
      (strlen($_POST['user']) >= 4 && strlen($_POST['user']) <= 20) &&
      (strlen($_POST['password']) >= 8 && strlen($_POST['password']) <= 18) &&
      (strlen($_POST['name']) >= 4 && strlen($_POST['password']) <= 50)
      ) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $name = $_POST['name'];

        // crear nuevo usuario
        $cnx = mysqli_connect('localhost', 'root', 'password', 'demo')
          or die('Error en la conexión a MySQL');

        if (mysqli_connect_error()) {
          header('Location: login_error.php');
          exit();
        }
        $res = mysqli_query($cnx, "INSERT INTO USUARIO (nombre, usuario, contrasenia) VALUES ('{$name}', '{$user}', '{$password}')");

        
        while($registro = mysqli_fetch_row($res)) {
          if ($password == $registro[3]){
            $_SESSION['user'] = $user;
            $_SESSION['isLogged'] = TRUE;
            $_SESSION['recordarme'] = $recordarme;
        
            header('Location: welcome.php');
            exit;
          }
        }
        
        
        header('Location: login.php');
        exit;
    } else {
      header('Location: signin.php');
      exit;
    } 
  } else {
    header('Location: signin.php');
    exit;
  }
?>
