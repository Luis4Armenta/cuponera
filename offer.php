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

$title = $offer['title'];
include 'shared/header.php';
?>

<div class="container">
  <div class="row">
    <div class="card pb-3 pt-3">
      <?php if (isset($offer['end_date'])): ?>
        <div class="row mx-2 mb-2">
          <?php
          // Fecha dada

          $fechaDada = new DateTime($offer['end_date']);
          if (isset($offer['end_time'])) {
            $fechaDada = new DateTime($offer['end_date'] . ' ' . $offer['end_time']);
          }

          // Fecha actual
          $fechaActual = new DateTime();

          // Calcular la diferencia entre las dos fechas
          $diferencia = $fechaDada->diff($fechaActual);

          // Convertir la diferencia a horas
          $horasDiferencia = ($diferencia->days * 24) + $diferencia->h + ($diferencia->i / 60) + ($diferencia->s / 3600);
          ?>
          <?php if ($horasDiferencia > 24*7 && $fechaDada > $fechaActual): ?>
            <div class="alert alert-primary text-center" role="alert">
              <i class="bi bi-clock me-1 fw-bolder"></i> La oferta termina el <span class="fw-bolder"><?php echo "{$fechaDada->format('d M Y')}"; ?></span> <?php echo isset($offer['end_time']) ? "a las {$fechaDada->format('H:i')}" : ""; ?>
            </div>
          <?php elseif ($fechaDada > $fechaActual && $horasDiferencia > 24): ?>
            <div class="alert alert-warning text-center" role="alert">
              <i class="bi bi-clock me-1 fw-bolder"></i> La oferta termina el <span class="fw-bolder"><?php echo "{$fechaDada->format('d M Y')}"; ?></span> <?php echo isset($offer['end_time']) ? "a las {$fechaDada->format('H:i')}": ""; ?>
            </div>
            <?php else: ?>
              <div class="alert alert-secondary text-center" role="alert">
                <i class="bi bi-exclamation-circle"></i> Lamentablemente esta oferta caduco el <span><?php echo "{$fechaDada->format('d M Y')}"; ?> <?php echo isset($offer['end_time']) ? "a las {$fechaDada->format('H:i')}": ""; ?></span>
              </div>

          <?php endif; ?>

        </div>
      <?php endif; ?>
      <div class="row g-0 mx-2">
        <div class="col-md-4">
          <img src="<?php echo $offer['image_link']; ?>" class="img-fluid rounded-start" alt="Imagen del articulo/servicio">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                publicado hace 2 días
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h3 class="fw-bolder">Seat Leon version Style - 2024</h3>
              </div>
            </div>
            <div class="row row-cols-auto">
              <div class="col-md-12">
                <span class="fs-3 fw-bolder text-success">$400,900</span>
                <span class="fs-4 text-secondary text-decoration-line-through">$505,900</span>
                <span class="fs-4">
                  -7%
                </span> 
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <span class="text-success fs-5">Seat</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <a href="#" class="btn btn-success btn-lg fs-4 rounded-5">Ir a la oferta <i class="bi bi-box-arrow-up-right"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <a class="align-middle text-decoration-none text-dark" href="#">
                  <img src="assets/images/user.png" class="rounded-circle border" height="22" alt="Avatar" loading="lazy"/>
                  Compartido por <span class="fw-semibold">juan.delaspitas</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-2">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <h3>Acerca de esta oferta</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            Deacuento en la versión de Entrada de Seat León.

            Para los que han querido tener un Leon... Ahora es cuando. Con este precio ya vale igual que los Omoda y los Chirey...
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <span class="text-secondary">Vehiculos</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include 'shared/footer.php'; ?>