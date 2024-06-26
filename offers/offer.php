<?php
include_once '../utils.php';
include_once '../config.php';
include_once '../Database.php';
session_start();

if (!isset($_GET['id'])) {
  header('Location: ../index.html');
  exit;
}

$data = sanitize_input($_GET, array('id' => 'int'));
$id = $data['id'];

$user_is_owner = False;
$user_is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2 ? True : False ;

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
      'timestamp' => $registro[18],
      'creator_avatar_link' => $registro[19],
      'creator_user_id' => $registro[20],
    );
  }
  $user_is_owner = isset($_SESSION['user']) && $_SESSION['user'] == $offer['creator_username'] ? True : False;
  $res->free_result();
  $database->closeConnection();
  if (!isset($offer['deal_id'])) {
    header('Location: ../shared/errors/404.php');
  }
} catch (mysqli_sql_exception $e) {
  header('Location: ../shared/errors/500.php');
  exit;
}

$title = $offer['title'];
include '../shared/header.php';
?>

<div class="container">
  <div class="row mt-2">
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
          <?php elseif ($fechaDada > $fechaActual && $horasDiferencia > 0): ?>
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
          <div class="bg-body-tertiary w-100 h-100 d-flex justify-content-center align-items-center">
            <img src="<?php echo $offer['image_link']; ?>" class="img-fluid rounded-start" alt="Imagen del articulo/servicio">
          </div>
        </div>
        <div class="col-md-<?php echo $user_is_owner || $user_is_admin ? '7' : '8';?>">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <span class="text-secondary fs-6">
                  <?php
                    $publish_date = new DateTime($offer['timestamp']);
                    $actual_date = new DateTime();

                    $difference = $publish_date->diff($actual_date); 
                  ?>
                  Publicado el <?php echo $publish_date->format('d M Y'); ?> a las <?php echo $publish_date->format('H:i'); ?>
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h3 class="fw-bolder"><?php echo_sanitized($title); ?></h3>
              </div>
            </div>
            <?php if (isset($offer['offer_price'])): ?>
            <div class="row row-cols-auto">
              <div class="col-md-12">
                <span class="fs-3 fw-bolder text-success">$<?php echo number_format($offer['offer_price'], 2); ?></span>
                <?php if (isset($offer['regular_price'])): ?>
                  <span class="fs-4 text-secondary text-decoration-line-through">$<?php echo number_format($offer['regular_price']) ?></span>
                  <span class="fs-4">
                    -<?php echo floor($offer['offer_price'] / $offer['regular_price'] * 100); ?>%
                  </span>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>
            <div class="row row-cols-auto my-3">
              <div class="col-md-12">
                <?php if ($offer['availability' ] == 'OFFLINE'): ?>
                  <span class="text-secondary fs-5"><i class="bi bi-shop mx-1"></i>Local</span>
                <?php else: ?>
                  <span class="text-secondary fs-5"><i class="bi bi-truck me-1"></i><?php echo $offer['shipping_cost'] != 0 ? "\${$offer['shipping_cost']}" : "Gratis"; ?> </span>
                <?php endif; ?>
              |
                <span class="text-success fs-5"><?php echo_sanitized($offer['store']); ?></span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <a href="<?php echo $offer['link']; ?>" class="btn btn-success btn-lg fs-4 rounded-5 w-100">Ir a la oferta <i class="bi bi-box-arrow-up-right"></i></a>
              </div>
              <?php if (isset($offer['coupon_code']) && $offer['coupon_code'] != ""): ?>
                <div class="col-md-6">
                  <button onclick="copy_coupon()" class="btn btn-outline-secondary btn-lg fs-4 rounded-5 w-100" style="border-style: dashed;"><span id="coupon" class="mx-3"><?php echo_sanitized($offer['coupon_code']); ?></span><i class="bi bi-copy text-success"></i></button>
                </div>
              <?php endif;  ?>
            </div>
            <div class="row">
              <div class="col-md-12">
                <a class="align-middle text-decoration-none text-dark" href="#">
                  <img src='<?php echo $offer['creator_avatar_link'] == null || $offer['creator_avatar_link'] == "" ? "/assets/images/user.png" : $offer['creator_avatar_link']; ?>' class="rounded-circle border" height="22" alt="Avatar" loading="lazy"/>
                  Compartido por <span class="fw-semibold"><?php echo $offer['creator_username']; ?></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php if ($user_is_owner || $user_is_admin): ?>
        <div class="col-md-1">
          <div class="row m-0 p-0">
            <div class="col-md-12 d-flex flex-column align-items-end gap-3 p-0 m-0">
                <button id="return-btn" class="mx-0 btn btn-dark" data-toggle="tooltip" data-placement="left" title="Regresar"><i class="bi bi-arrow-return-left"></i></button>
                <?php if ($user_is_owner): ?>
                  <a href="share.php?id=<?php echo $offer['deal_id']; ?>" class="mx-0 btn btn-primary" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bi bi-pen"></i></a>
                <?php endif; ?>
                <button id="delete-btn" class="mx-0 btn btn-danger" data-toggle="tooltip" data-placement="left" title="Borrar"><i class="bi bi-trash"></i></button>
            </div>
          </div>
        </div>
        <?php endif; ?>
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
            <?php echo htmlspecialchars($offer['description'], ENT_QUOTES, 'UTF-8'); ?> 
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <span class="text-secondary"><?php echo $offer['category_name']; ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function copy_coupon() {
    var copyText = document.getElementById("coupon");
    navigator.clipboard.writeText(copyText.textContent);
  } 
  </script>
  <script>
  on_load = () => {

    $('#delete-btn').on('click', function(event) {
          event.preventDefault();
          var row = $(this).closest('tr');
          Swal.fire({
              title: '¿Estás seguro?',
              text: "No podrás revertir esta acción!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, eliminar!',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.isConfirmed) {
                  var ajax = new XMLHttpRequest();
                  ajax.onreadystatechange = () => {
                    if (ajax.readyState == 4 && ajax.status == 200) {
                      Swal.fire(
                        'Eliminado!',
                        'El registro ha sido eliminado.',
                        'success'
                      );
                      if (window.history.length > 2) {
                        window.history.go(-1);
                      } else {
                        window.location.replace("../index.php");
                      }
                    }
                  }
                  ajax.open('POST', 'actions/delete_offer.php', true);
                  ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                  ajax.send('id=' + encodeURIComponent(<?php echo $offer['deal_id']; ?>));
              }
          });
      });


      $('#return-btn').on('click', function(event) {
        if (window.history.length > 2) {
          window.history.go(-1);
        } else {
          window.location.replace("../index.php");
        }
      });

      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
  }
</script>

<?php include '../shared/footer.php'; ?>
