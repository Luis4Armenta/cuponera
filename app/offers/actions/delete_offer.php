<?php
ini_set('display_errors', E_ALL);
include_once '../../config.php';
include_once '../../Database.php';
include_once '../../utils.php';

session_start();
if (!isset($_SESSION['user'])) {
    Header('Location: ../../auth/login.php');
    exit;
}

$expected_fields = array(
    'id' => 'int',
);

$data = sanitize_input($_POST, $expected_fields);

if (isset($data['id'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();

        // Preparar la consulta SQL
        $query = "DELETE FROM deals WHERE deal_id = ?";

        $stmt = $db->prepare($query);

        // Verificar si hay errores en la preparación de la consulta
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $db->error;
            exit;
        }

        // Vincular el parámetro a la consulta
        $stmt->bind_param("i", $data['id']);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Éxito";
        } else {
            echo "Error";
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $database->closeConnection();
        exit;

    } catch (mysqli_sql_exception $e) {
        header('Location: ../../shared/errors/500.php');
        exit;
    }
} else {
    Header('Location: ../share.php');
    exit;
}
?>
