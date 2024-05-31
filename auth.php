<?php
ini_set('display_errors', E_ALL);
include_once 'utils.php';
include_once 'config.php';
include_once 'Database.php';
session_start();

$data = sanitize_post_data($_POST);

if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}

if (isset($data['user']) && isset($data['password'])) {
  if (
    (strlen($data['user']) >= 4 && strlen($data['user']) <= 20) &&
    (strlen($data['password']) >= 8 && strlen($data['password']) <= 16)
  ) {
    $user_pattern = '/^[a-zA-Z0-9_-]+$/';
    if (
      !preg_match($user_pattern, $data['user'])
    ) {
      header('Location: login.php');
      exit;
    }

    $user = $data['user'];
    $password = $data['password'];
    $recordarme = isset($data['recordarme']);

    try {
      $database = new Database();
      $db = $database->getConnection();
      $res = $db->query("SELECT * FROM USUARIO WHERE usuario = '" . $user . "' limit 1;");

      while ($registro = $res->fetch_row()) {
        if ($password == $registro[3]) {
          $_SESSION['user'] = $user;

          header('Location: welcome.php');
        }
      }
      header('Location: login_error.php');
      exit;
    } catch (mysqli_sql_exception $e) {
      header('Location: shared/errors/500.php');
      exit;
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
