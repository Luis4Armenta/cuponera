<?php
session_start();

if (!(isset($_SESSION['user']) && isset($_SESSION['user_id']))) {
  die('No autorizado...');
}

include_once '../../config.php';
include_once '../../Database.php';
include_once '../../utils.php';


$message = array('message' => 'error', 'url' => '');

  // TODO: cargar imagen
  $image = $_FILES['image'];

  $maxFileSize = 10 * 1024 * 1024; // 10 MB

  // Verifica si el archivo es una imagen
  $check = getimagesize($image['tmp_name']);
  if ($check === false) {
      die("El archivo no es una imagen.");
  }

  // Verifica el tamaño del archivo
  if ($image['size'] > $maxFileSize) {
      die("El archivo es demasiado grande. Máximo 2MB.");
  }

  // Verifica si hay errores en la subida del archivo
  if ($image['error'] !== UPLOAD_ERR_OK) {
      die("Error al subir la imagen.");
  }

  // Verificar tipo MIME
  $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
  if (!in_array($image['type'], $allowedMimeTypes)) {
      die("Solo se permiten archivos JPG, PNG y GIF.");
  }

  $api_key = getenv('CLOUDINARY_API_KEY');
  $cloud_name = getenv('CLOUDINARY_CLOUD_NAME');
  $cloudinary_upload_preset = getenv('CLOUDINARY_UPLOAD_PRESET');


  $cloudinary_url = "https://api.cloudinary.com/v1_1/{$cloud_name}/image/upload";
  
  // Cargar la imagen a Cloudinary
  $image_path = $image['tmp_name'];

  // Inicializa una solicitud cURL
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $cloudinary_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);

  $post = array(
      'api_key' => $api_key,
      'file' => new CURLFile($image_path),
      'upload_preset' => $cloudinary_upload_preset
  );

  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


  // $headers = array();
  // $headers[] = 'Authorization: Basic ' . base64_encode($api_key . ':' . $api_secret);
  // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
      die('Error en cURL: ' . curl_error($ch));
  }

  curl_close($ch);

  $res = json_decode($response, true);
// TODO: obtener url de la imagen cargada

$image_url = "";
if (isset($res['secure_url'])) {
  $image_url = $res['secure_url'];
}


try {
  $query = "UPDATE Users SET avatar_link = '{$image_url}' WHERE user_id = {$_SESSION['user_id']}";

  $database = new Database();
  $db = $database->getConnection();
  $res = $db->query($query);
  if ($res === TRUE) {
    $message['message'] = 'Success';
    $message['url'] = $image_url;
    $_SESSION['avatar'] =$image_url;
  } else {
    $message['message'] = 'Error';
  }
  $database->closeConnection();
} catch (mysqli_sql_exception $e) {
  $message['message'] = 'Error';
}

echo json_encode($message);