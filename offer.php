<?php
include_once 'utils.php';
include_once 'config.php';
include_once 'Database.php';

if (!isset($_GET['id'])) {
  header('Location: index.html');
  exit;
}

$data = sanitize_input($_GET, array('id' => 'int'));
$id = $data['id'];

try {
  $database = new Database();
  $db = $database->getConnection();
  $res = $db->query("SELECT * FROM DealInformation WHERE deal_id = {$id} limit 1;");

  $offer = array();
  while ($registro = $res->fetch_row()) {
    $offer = array(
      'deal_id' => $registro[0],
      'title' => $registro[1],  
      'coupon_code' => $registro[2],  
      'link' => $registro[3],  
      'start_date' => $registro[4],  
      'end_date' => $registro[5],  
      'start_time' => $registro[6],  
      'end_time' => $registro[7],  
      'description' => $registro[8],  
      'regular_price' => $registro[9],  
      'offer_price' => $registro[10],  
      'availability' => $registro[11],  
      'shipping_cost' => $registro[12],  
      'shipping_address' => $registro[13],  
      'store' => $registro[14],
      'category_name' => $registro[15],
      'creator_username' => $registro[16],
      'image_link' => $registro[17],
    );
  }

  $res->free_result();
  $database->closeConnection();
  if (!isset($offer['deal_id'])) {
    header('Location: shared/errors/404.php');
  }
} catch (mysqli_sql_exception $e) {
  header('Location: shared/errors/500.php');
  exit;
}


include 'shared/header.php';
?>

<div class="container">
  <div class="row">
    <div class="card mb-3">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="<?php echo $offer['image_link']; ?>" class="img-fluid rounded-start" alt="Imagen del articulo/servicio">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"><?php echo $offer['title']; ?></h5>
            <p class="card-text"><?php echo $offer['description']; ?></p>
            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include 'shared/footer.php'; ?>