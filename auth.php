<?php
ini_set('display_errors', E_ALL);
include_once 'utils.php';
include_once 'config.php';
include_once 'Database.php';
session_start();


if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}

$expected_fields = array(
  'user' => 'string',
  'password' => 'string'
);

$regex = array(
  'user' => '/^[a-zA-Z0-9_-]{4,20}$/',
  'password' => '/^.{8,16}$/'
);

$data = sanitize_input($_POST, $expected_fields, $regex);

if (all_fields_exist($data, $expected_fields)) {
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
?>
