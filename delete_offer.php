<?php
ini_set('display_errors', E_ALL);
include_once 'config.php';
include_once 'Database.php';
include_once 'utils.php';

session_start();
if (!isset($_SESSION['user'])) {
  Header('Location: login.php');
  exit;
}

$expected_fields = array(
  'id' => 'int',
);


$data = sanitize_input($_POST, $expected_fields);

if (isset($data['id'])) {
  try {
    $query = "DELETE FROM DEALS WHERE deal_id = {$data['id']}; ";

    $database = new Database();
    $db = $database->getConnection();
    $res = $db->query($query);

    if ($res === TRUE) {
      echo "Exito";
    } else {
      echo "error";
    }
    
    // $res->free_result();
    $database->closeConnection();
    exit;

  } catch (mysqli_sql_exception $e) {
    header('Location: shared/errors/500.php');
    exit;
  }
} else {
  Header('Location: share.php');
  exit;
}
?>