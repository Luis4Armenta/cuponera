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
