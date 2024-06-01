<?php
ini_set('display_errors', E_ALL);
include_once 'config.php';
include_once 'Database.php';
include_once 'utils.php';

session_start();

$data = sanitize_input($_POST, array(
  'user' => 'string',
  'name' => 'string',
  'password' => 'string',
), array(
  'user' => '/^[a-zA-Z0-9_-]{4,20}$/',
  'name' => '/^[a-zA-Z\s]{4,40}$/',
  'password' => '/^.{8,40}$/'
)
);

if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}

if (isset($data['user']) && isset($data['name']) && isset($data['password'])) {
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
    } else {
      header('Location: shared/errors/500.php');
    }

    // $res->free_result();
    $database->closeConnection();
    exit;

  } catch (mysqli_sql_exception $e) {
    header('Location: shared/errors/500.php');
    exit;
  }

} else {
  header('Location: signin.php');
  exit;
}
?>
