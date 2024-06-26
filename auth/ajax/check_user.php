<?php
include '../../config.php';
include '../../Database.php';
include '../../utils.php';

$response = array('userAvailable' => false);

$data = sanitize_input($_POST, array('user' => 'string'), array('user' => '/^[a-zA-Z0-9_-]{4,20}$/'));

if ($data != null) {
    $user = $data['user'];

    $database = new Database();
    $db = $database->getConnection();

    $sql = "SELECT COUNT(*) as totalRegistros FROM Users WHERE username = '{$user}'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $totalRegistros = $row['totalRegistros'];

  
    if ($totalRegistros == 0) {
      $response['userAvailable'] = true;
    }
}

echo json_encode($response);
