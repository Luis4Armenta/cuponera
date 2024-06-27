<?php
include_once '../../config.php';
include_once '../../Database.php';
include_once '../../utils.php';
session_start();

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

    $default_role = 3;

    $query = "INSERT INTO Users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt ->bind_param("sssi", $user, $email, $password, $default_role);

    if ($stmt->execute()) {
      $user_id = $stmt->insert_id;
      $res = $db->query("SELECT * FROM Users WHERE user_id = {$user_id} limit 1;");

      if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();

        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['role_id'];
        $_SESSION['avatar'] = $user['avatar_link'];

        header('Location: ../../index.php');
      }
      $res->free_result();
    } else {
      header('Location: ../../shared/errors/500.php');
    }
    $stmt->close();
    $database->closeConnection();
    exit;

  } catch (mysqli_sql_exception $e) {
    switch ($e->getCode()) {
      case 1062:
        die('El usuario ya existe...');
      
      default:
        die('Error desconocido...');
      }
  }

} else {
  header('Location: ../signin.php');
  exit;
}
