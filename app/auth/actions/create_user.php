<?php
ini_set('display_errors', E_ALL);
include_once '../../config.php';
include_once '../../Database.php';
include_once '../../utils.php';

if (isset($_SESSION['user'])) {
  header('Location: ../../index.php');
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
    $res = $db->query("INSERT INTO Users (username, email, password, role_id) VALUES ( '{$user}', '{$email}', '{$password}', 3)");

    if ($res === TRUE) {
      $user_id = mysqli_insert_id($db);
      $res = $db->query("SELECT * FROM Users WHERE user_id = {$user_id} limit 1;");

      while ($registro = $res->fetch_row()) {
        if ($password == $registro[3]) {
          $_SESSION['user'] = $registro[1];
          $_SESSION['user_id'] = $registro[0];
          $_SESSION['user_role'] = $registro[5];
  
          header('Location: ../../login.php');
        }
      }
    } else {
      header('Location: ../../shared/errors/500.php');
    }

    // $res->free_result();
    $database->closeConnection();
    exit;

  } catch (mysqli_sql_exception $e) {
    header('Location: ../../shared/errors/500.php');
    exit;
  }

} else {
  header('Location: ../signin.php');
  exit;
}
