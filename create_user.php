<?php
ini_set('display_errors', E_ALL);
include_once 'config.php';
include_once 'Database.php';
include_once 'utils.php';

session_start();

$data = sanitize_post_data($_POST);

if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}

if (isset($data['user']) && isset($data['name']) && isset($data['password'])) {
  if (
    (strlen($data['user']) >= 4 && strlen($data['user']) <= 20) &&
    (strlen($data['password']) >= 8 && strlen($data['password']) <= 16) &&
    (strlen($data['name']) >= 4 && strlen($data['name']) <= 40)
  ) {
    $user_pattern = '/^[a-zA-Z0-9_-]+$/';
    $name_pattern = '/^[a-zA-Z\s]+$/';
    if (
      !(preg_match($user_pattern, $data['user']) &&
      preg_match($name_pattern, $data['name']))
    ) {
      header('Location: signin.php');
      exit;
    }
    $user = $data['user'];
    $password = $data['password'];
    $name = $data['name'];

    try {
      $database = new Database();
      $db = $database->getConnection();
      $res = $db->query("INSERT INTO USUARIO (nombre, usuario, contrasenia) VALUES ('{$name}', '{$user}', '{$password}')");
  
      if ($res === TRUE) {
        $_SESSION['user'] = $user;
        $_SESSION['isLogged'] = TRUE;
  
        header('Location: welcome.php');
        exit;
      } else {
        header ('Location: shared/errors/500.php');
        exit;
      }
    } catch (mysqli_sql_exception $e) {
      header('Location: shared/errors/500.php');
      exit;
    }
  }
  header('Location: signin.php');
  exit;
} else {
  header('Location: signin.php');
  exit;
}
?>
