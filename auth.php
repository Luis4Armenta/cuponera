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
      
        if ($user == 'user' && $password == 'password') {
          $_SESSION['user'] = $user;
          $_SESSION['isLogged'] = TRUE;
          $_SESSION['recordarme'] = $recordarme;
      
          header('Location: welcome.php');
        } else {
          header('Location: login_error.php');
        }
    } else {
      header('Location: login.php');
      exit;
    } 
  } else {
    header('Location: login.php');
    exit;
  }
?>
