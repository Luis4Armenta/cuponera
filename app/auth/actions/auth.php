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

    // Preparar la consulta
    $query = "SELECT * FROM Users WHERE username = ? LIMIT 1";
    $stmt = $db->prepare($query);

    // Validar si la preparación fue exitosa
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($db->error));
    }

    // Asignar los parámetros con bind_param
    $stmt->bind_param('s', $user);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $res = $stmt->get_result();

    while ($registro = $res->fetch_row()) {
        if ($password == $registro[3]) {
            $_SESSION['user'] = $registro[1];
            $_SESSION['user_id'] = $registro[0];
            $_SESSION['avatar'] = $registro[4];
            $_SESSION['user_role'] = $registro[5];
            setcookie('rememberme', 'on', time() + 3600 * 24 * 30);

            header('Location: ../../index.php');
            exit;
        }
        header('Location: /auth/login_error.php');
        exit;
      }
      
      // Cerrar la declaración y la conexión
      $stmt->close();
      $db->close();
      header('Location: /auth/login_error.php');
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
