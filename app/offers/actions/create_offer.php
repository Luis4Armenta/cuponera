<?php
ini_set('display_errors', E_ALL);
include_once '../../config.php';
include_once '../../Database.php';
include_once '../../utils.php';

function validateDateTime($startDate=null, $startTime=null, $endDate=null, $endTime=null) {
  if ($startDate != null && $endDate != null) {
      $startDateTime = new DateTime($startDate . ' ' . ($startTime ?: '00:00:00'));
      $endDateTime = new DateTime($endDate . ' ' . ($endTime ?: '23:59:59'));

      if ($startDateTime >= $endDateTime) {
          return ['valid' => false, 'message' => 'La fecha de inicio debe ser antes que la de fin.'];
      }

      $now = new DateTime();
      if ($endDateTime <= $now) {
          return ['valid' => false, 'message' => 'La fecha de fin debe ser futura.'];
      }
  }
  return ['valid' => true];
}

session_start();
if (!isset($_SESSION['user'])) {
  Header('Location: ../../auth/login.php');
  exit;
}

$expected_fields = array(
  'url' => 'url',
  'title' => 'string',
  'store' => 'string',
  'offerPrice' => 'float',
  'normalPrice' => 'float',
  'cupon' => 'string',
  'availability' => 'string',
  'shippingCost' => 'float',
  'shippingAddress' => 'string',
  'description' => 'string',
  'startDate' => 'string',
  'endDate' => 'string',
  'startTime' => 'string',
  'endTime' => 'string',
  'category' => 'int',
);

$regex = array(
  'title' => '/^.{4,140}$/',
  'store' => '/^[a-zA-Z0-9\s]+$/',
  'description' => '/^.{1,1000}$/',
  'availability' => '/^(online)|(offline)$/',
  'shippingAddress' => '/^.{2,50}$/',
  'startDate' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
  'endDate' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
  'startTime' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/',
  'endTime' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'
);

$data = sanitize_input($_POST, $expected_fields, $regex);
$dates_validation = validateDateTime($data['startDate'], $data['startTime'], $data['endDate'], $data['endTime']);

if ($dates_validation['valid'] == False) {
  die(400);
}

if (
  isset($data['url']) &&
  isset($data['title']) &&
  isset($data['store']) &&
  isset($data['availability']) &&
  isset($data['description']) &&
  isset($data['category'])
) {

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

  // insertar a la base de datos
  
  
  // Recibe y limpia los datos
  $normalPrice = isset($data['normalPrice']) && $data['normalPrice'] != '' ? $data['normalPrice'] : NULL;
  $offerPrice = isset($data['offerPrice']) && $data['offerPrice'] != '' ? $data['offerPrice'] : NULL;
  $coupon = isset($data['cupon']) && $data['cupon'] != '' ? $data['cupon'] : NULL;
  $shippingCost = isset($data['shippingCost']) && $data['shippingCost'] != '' ? $data['shippingCost'] : NULL;
  $shippingAddress = isset($data['shippingAddress']) && $data['shippingAddress'] != '' ? $data['shippingAddress'] : NULL;
  $startDate = isset($data['startDate']) && $data['startDate'] != '' ? $data['startDate'] : NULL;
  $endDate = isset($data['endDate']) && $data['endDate'] != '' ? $data['endDate'] : NULL;
  $startTime = isset($data['startTime']) && $data['startTime'] != '' ? $data['startTime'] : NULL;
  $endTime = isset($data['endTime']) && $data['endTime'] != '' ? $data['endTime'] : NULL;

  $database = new Database();
  $db = $database->getConnection();

  try {
    $query = "
    INSERT INTO deals (
      link,
      store,
      title,
      regular_price,
      offer_price,
      coupon_code,
      availability,
      shipping_cost,
      shipping_address,
      image_link,
      description,
      start_date,
      end_date,
      start_time,
      end_time,
      category_id,
      user_id
      ) VALUES (
      ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $db->prepare($query);

    // Vincular los parámetros
    $stmt->bind_param(
        "sssddssdsssssssii",
        $data['url'],
        $data['store'],
        $data['title'],
        $normalPrice,
        $offerPrice,
        $coupon,
        $data['availability'],
        $shippingCost,
        $shippingAddress,
        $image_url,
        $data['description'],
        $startDate,
        $endDate,
        $startTime,
        $endTime,
        $data['category'],
        $_SESSION['user_id']
    );

    // Ejecutar la declaración
    if ($stmt->execute()) {
      $id = $stmt->insert_id;
      header("Location: ../offer.php?id={$id}");
    } else {
      header('Location: ../../shared/errors/500.php');
    }

    
    // Cerrar la conexión
    $stmt->close();
    $database->closeConnection();
    exit;
  } catch (mysqli_sql_exception $e) {
    // header('Location: ../../shared/errors/500.php');
    echo $e;
    exit;
  }
} else {
  Header('Location: ../share.php');
  exit;
}