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
  
    $api_key = getenv('cloudinary_api_key');
    $cloud_name = getenv('cloudinary_cloud_name');
    $cloudinary_upload_preset = getenv('cloudinary_upload_preset');


    $cloudinary_url = "https://api.cloudinary.com/v1_1/{$cloud_name}/demo/image/upload";
    
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
  

  $normalPrice = isset($data['normalPrice']) && $data['normalPrice'] != '' ? "{$data['normalPrice']}" : 'NULL';
  $offerPrice = isset($data['offerPrice']) && $data['offerPrice'] != '' ? "{$data['offerPrice']}" : 'NULL';
  $coupon = isset($data['cupon']) && $data['cupon'] != '' ? "'{$data['cupon']}'" : 'NULL';
  $shippingCost = isset($data['shippingCost']) && $data['shippingCost'] != '' ? "{$data['shippingCost']}" : 'NULL';
  $shippingAddress = isset($data['shippingAddress']) && $data['shippingAddress'] != '' ? "'{$data['shippingAddress']}'" : 'NULL';
  $startDate = isset($data['startDate']) && $data['startDate'] != '' ? "'{$data['startDate']}'" : 'NULL';
  $endDate = isset($data['endDate']) && $data['endDate'] != '' ? "'{$data['endDate']}'" : 'NULL';
  $startTime = isset($data['startTime']) && $data['startTime'] != '' ? "'{$data['startTime']}'" : 'NULL';
  $endTime = isset($data['endTime']) && $data['endTime'] != '' ? "'{$data['endTime']}'" : 'NULL';

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
      '{$data['url']}',
      '{$data['store']}',
      '{$data['title']}',
      $normalPrice,
      $offerPrice,
      $coupon,
      '{$data['availability']}',
      $shippingCost,
      $shippingAddress,
      '{$image_url}',
      '{$data['description']}',
      $startDate,
      $endDate,
      $startTime,
      $endTime,
      {$data['category']},
      {$_SESSION['user_id']}
    );
  ";

    $database = new Database();
    $db = $database->getConnection();
    $res = $db->query($query);

    if ($res === TRUE) {
      $id = mysqli_insert_id($db); 

      header("Location: offer.php?id={$id}");
    } else {
      header('Location: shared/errors/500.php');
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