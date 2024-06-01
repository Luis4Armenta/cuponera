<?php
ini_set('display_errors', E_ALL);
include_once 'config.php';
include_once 'Database.php';
include_once 'utils.php';

session_start();

if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}

$expected_fields = array(
  'user' => 'string',
  'email' => 'email',
  'password' => 'string',
);

$regex = array(
  'user' => '/^[a-zA-Z0-9_-]{4,20}$/',
  'password' => '/^.{8,40}$/'
);

$data = sanitize_input($_POST, $expected_fields, $regex);


if (all_fields_exist($data, $expected_fields)) {
  $user = $data['user'];
  $password = $data['password'];
  $email = $data['email'];

  try {
    $database = new Database();
    $db = $database->getConnection();
    $res = $db->query("INSERT INTO Users (username, email, password, terms_accepted, role_id) VALUES ( '{$user}', '{$email}', '{$password}', 1, 3)");

    if ($res === TRUE) {
      $_SESSION['user'] = $user;

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
