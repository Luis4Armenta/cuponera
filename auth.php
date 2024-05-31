<?php
  session_start();

  include 'utils.php';
  
  $data = sanitize_post_data($_POST);

  if (isset($_SESSION['user'])) {
    header('Location: welcome.php');
    exit;
  }

  if (isset($data['user']) && isset($data['password'])) {
    if (
      (strlen($data['user']) >= 4 && strlen($data['user']) <= 20) &&
      (strlen($data['password']) >= 8 && strlen($data['password']) <= 18)
      ) {
        $user = $data['user'];
        $password = $data['password'];
        $recordarme = isset($data['recordarme']);

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
        
        mysqli_free_result($res);
        mysqli_close($cnx);


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
