<?php
include_once '../../config.php';
include_once '../../Database.php';
include_once '../../utils.php';

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
  'startDate' => 'stirng',
  'endDate' => 'stirng',
  'startTime' => 'stirng',
  'endTime' => 'stirng',
  'category' => 'int',
  'id' => 'int',
  'image' => 'url',
);

$regex = array(
  'title' => '/^.{4,140}$/',
  'store' => '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]{1,50}+$/',
  'description' => '/^.{1,1000}$/',
  'availability' => '/^(online)|(offline)$/',
  'shippingAddress' => '/^.{2,50}$/',
  'startDate' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
  'endDate' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
  'startTime' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/',
  'endTime' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'
);

$data = sanitize_input($_POST, $expected_fields, $regex);

if (
  isset($data['url']) &&
  isset($data['title']) &&
  isset($data['store']) &&
  isset($data['availability']) &&
  isset($data['description']) &&
  isset($data['category'])
) {
  if (count($_FILES) == 1 && $_FILES['image']['name'] != '') {
  // cargar imagen
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

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Error en cURL: ' . curl_error($ch));
    }

    curl_close($ch);

    $res = json_decode($response, true);

  // obtener url de la imagen cargada

  $image_url = "";
  if (isset($res['secure_url'])) {
    $image_url = $res['secure_url'];
  }

  // insertar a la base de datos
} else {
  $image_url = $data['image'];
}
  

  $normalPrice = isset($data['normalPrice']) && $data['normalPrice'] != '' ? $data['normalPrice'] : NULL;
  $offerPrice = isset($data['offerPrice']) && $data['offerPrice'] != '' ? $data['offerPrice'] : NULL;
  $coupon = isset($data['cupon']) && $data['cupon'] != '' ? $data['cupon'] : NULL;
  $shippingCost = isset($data['shippingCost']) && $data['shippingCost'] != '' ? $data['shippingCost'] : NULL;
  $shippingAddress = isset($data['shippingAddress']) && $data['shippingAddress'] != '' ? $data['shippingAddress'] : NULL;
  $startDate = isset($data['startDate']) && $data['startDate'] != '' ? $data['startDate'] : NULL;
  $endDate = isset($data['endDate']) && $data['endDate'] != '' ? $data['endDate'] : NULL;
  $startTime = isset($data['startTime']) && $data['startTime'] != '' ? $data['startTime'] : NULL;
  $endTime = isset($data['endTime']) && $data['endTime'] != '' ? $data['endTime'] : NULL;

  try {
    $database = new Database();
    $db = $database->getConnection();

    $res = $db->query("SELECT * FROM deals WHERE deal_id = {$data['id']} LIMIT 1;");
    if ($res->num_rows > 0 && isset($_SESSION['user_id'])) {
      $offer = $res->fetch_assoc();
      if ($offer['user_id'] != $_SESSION['user_id']) {
        die('Sin privilegios.');
      }
    } else {
      die('Oferta no encontrada.');
    }
    
    $res->free_result();

    $query = "
      UPDATE deals
      SET
          link = ?,
          store = ?,
          title = ?,
          regular_price = ?,
          offer_price = ?,
          coupon_code = ?,
          availability = ?,
          shipping_cost = ?,
          shipping_address = ?,
          image_link = ?,
          description = ?,
          start_date = ?,
          end_date = ?,
          start_time = ?,
          end_time = ?,
          category_id = ?
      WHERE
          deal_id = ?
    ";

    $stmt = $db->prepare($query);

    if (!$stmt) {
      header('Location: ../../shared/error/500.php');
      exit;
    }

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
      $data['id']
    );


    if ($stmt->execute()) {
      header("Location: ../offer.php?id={$data['id']}");
    } else {
      header('Location: ../../shared/errors/500.php');
    }

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