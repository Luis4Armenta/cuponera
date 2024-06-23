<?php
include_once '../../utils.php';
include_once '../../config.php';
include_once '../../Database.php';
session_start();

if (isset($_SESSION['user'])) {
  header('Location: ../../index.php');
  exit;
}

$expected_fields = array(
  'user' => 'string',
  'password' => 'string',
  'recordarme' => 'string'
);

$regex = array(
  'user' => '/^[a-zA-Z0-9_-]{4,20}$/',
  'password' => '/^.{8,16}$/',
  'recordarme' => '/^on$/'
);

$data = sanitize_input($_POST, $expected_fields, $regex);

if ($data['user'] != null && $data['password'] != null) {
  $user = $data['user'];
  $password = $data['password'];
  $recordarme = $data['recordarme'];

  try {
    $database = new Database();
    $db = $database->getConnection();
    $res = $db->query("SELECT * FROM Users WHERE username = '" . $user . "' limit 1;");

    while ($registro = $res->fetch_row()) {
      if ($password == $registro[3]) {
        $_SESSION['user'] = $registro[1];
        $_SESSION['user_id'] = $registro[0];
        $_SESSION['user_role'] = $registro[5];
        setcookie('rememberme', 'on', time() + 3600 * 24 * 30);

        header('Location: ../../index.php');
        exit;
      }
    }
    header('Location: ../login_error.php');
    exit;
  } catch (mysqli_sql_exception $e) {
    header('Location: ../../shared/errors/500.php');
    exit;
  }

} else {
  header('Location: ../login.php');
  exit;
}
?>
