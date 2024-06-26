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

    $sql = "SELECT COUNT(*) as totalRegistros FROM Users WHERE email = '{$email}'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $totalRegistros = $row['totalRegistros'];

  
    if ($totalRegistros == 0) {
      $response['emailAvailable'] = true;
    }
}

echo json_encode($response);
