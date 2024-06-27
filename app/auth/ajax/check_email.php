<?php
include '../../config.php';
include '../../Database.php';
include '../../utils.php';

$response = array('emailAvailable' => false);

$data = sanitize_input($_POST, array('email' => 'email'));

if ($data != null) {
  $email = $data['email'];

  $database = new Database();
  $db = $database->getConnection();
  
  // Preparar la consulta
  $sql = "SELECT COUNT(*) as totalRegistros FROM Users WHERE email = ?";
  $stmt = $db->prepare($sql);
  
  // Validar si la preparación fue exitosa
  if ($stmt === false) {
      die('Error en la preparación de la consulta: ' . htmlspecialchars($db->error));
  }
  
  // Asignar los parámetros con bind_param
  $stmt->bind_param('s', $email);
  
  // Ejecutar la consulta
  $stmt->execute();
  
  // Obtener el resultado
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $totalRegistros = $row['totalRegistros'];
  
  if ($totalRegistros == 0) {
      $response['emailAvailable'] = true;
  }
  
  // Cerrar la declaración y la conexión
  $stmt->close();
  $db->close();
}

echo json_encode($response);
