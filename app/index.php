<?php
ini_set('display_errors', E_ALL);
session_start();
include_once 'config.php';
include_once 'Database.php';
include_once 'utils.php';

$data = sanitize_input($_GET, array('mode' => 'string', 'page' => 'int'));
$mode = $data['mode'];
$page = $data['page'];
if ($mode == null) {
  $mode = 'foryou';
}

$registrosPorPagina = 11; // Número de registros por página

$offers = array();
try {
  $database = new Database();
  $db = $database->getConnection();

  $sql = "SELECT COUNT(*) as totalRegistros FROM {$mode}";
  $result = $db->query($sql);
  $row = $result->fetch_assoc();
  $totalRegistros = $row['totalRegistros'];

  $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
  $totalPaginas = $totalPaginas == 0 ? 1 : $totalPaginas;


  if ($page) {
    $paginaActual = $page;
  } else {
      $paginaActual = 1;
  }

  if ($paginaActual < 1) {
    $paginaActual = 1;
  } elseif ($paginaActual > $totalPaginas) {
      $paginaActual = $totalPaginas;
  }

  $offset = ($paginaActual - 1) * $registrosPorPagina;


  $res = $db->query("select * from {$mode} LIMIT {$registrosPorPagina} OFFSET {$offset};");

  
  while ($registro = $res->fetch_row()) {
    $start_datetime = new DateTime();
    $end_datetime = new DateTime($registro[3] . ' ' . $registro[4]);
    $creation_datetime = new DateTime($registro[16]);
    
    array_push($offers, array(
      'deal_id' => $registro[0],
      'title' => $registro[1],
      'image_link' => $registro[2],
      'end_date' => $registro[3],
      'end_time' => $registro[4],  
      'offer_price' => $registro[5],  
      'regular_price' => $registro[6],  
      'availability' => $registro[7],  
      'shipping_cost' => $registro[8],  
      'store' => $registro[9],
      'coupon_code' => $registro[10],
      'description' => $registro[11],  
      'creator_username' => $registro[12],
      'avatar_link' => $registro[13],
      'comment_count' => $registro[14],
      'link' => $registro[15],
      'start_datetime' => $start_datetime,
      'end_datetime' => $end_datetime,
      'creation_datetime' =>$creation_datetime,
      // 'shipping_address' => $registro[13],  
      // 'category_name' => $registro[15],
      
    ));
  }

  $res->free_result();
  $database->closeConnection();
} catch (mysqli_sql_exception $e) {
  echo $e;
  // header('Location: shared/errors/500.php');
  exit;
}

?>

<?php $title = 'Cuponera';?>
<?php $extra_styles = ['index.css']; ?>
<?php include 'shared/header.php' ?>


<?php
$categorias = array(
  'Tecnología' => 'tecnologia',
  'Videojuegos' => 'videojuegos',
  'Abarrotes y alimentos' => 'abarrotes_y_alimentos',
  'Ropa y accesorios' => 'ropa_y_accesorios',
  'Salud y belleza' => 'salud_y_belleza',
  'Familía, bebés y niños' => 'familia',
  'Hogar' => 'hogar',
  'Jardín y hazlo tú mismo' => 'jardin_y_hazlo_tu_mismo',
  'Autos y motos' => 'autos_y_motos',
  'Entrenamiento y tiempo libre' => 'entrenamiento',
  'Deportes y ejercicio' => 'deportes',
  'Internet y telefonía celular' => 'internet_y_telefonia',
  'Viajes' => 'viajes',
  'Finanzas y seguros' => 'finanzas_y_seguros',
  'Servicios y suscripciones' => 'servicios',
  'Gratis' => 'gratis'
);
$datetime_now = new DateTime();


?>

<div>
  <div class="categorias-bar-container border bg-body">
    <button class="scroll-button left fs-4" onclick="scrollLeft()">‹</button>
    <div class="categorias-bar" id="categoriasBar">
      <?php foreach ($categorias as $categoria => $value): ?>
        <div class="p-2">
          <a href="<?php echo "category.php?id={$value}" ?>" class="btn btn-primary btn-category"><?php echo $categoria; ?></a>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="scroll-button right fs-4" onclick="scrollRight()">›</button>
  </div>
  <nav class="navbar navbar-expand-lg bg-white border py-0">
    <div class="container">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="index.php" class="nav-link <?php echo !isset($_GET['mode']) || (isset($_GET['mode']) && $_GET['mode'] != 'hot' && $_GET['mode'] != 'news')  ? 'active' : ''; ?>">Para ti</a>
        </li>
        <li class="nav-item">
        <a href="index.php?mode=hot" class="nav-link <?php echo isset($_GET['mode']) && strtolower($_GET['mode']) == 'hot' ? 'active' : ''; ?>">Hot</a>
        </li>
        <li class="nav-item">
        <a href="index.php?mode=news" class="nav-link <?php echo isset($_GET['mode']) && strtolower($_GET['mode']) == 'news' ? 'active' : ''; ?>">Nuevas</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <?php if (count($offers) == 0): ?>
      <div class="card my-2 px-4 py-4">
        <div class="p-3 border">
          <h2 class="text-secondary text-center">
            <i class="bi bi-archive mx-2"></i> No se ha encontrado ninguna oferta
          </h2>
        </div>
      </div>
    <?php endif; ?>
    <?php foreach ($offers as &$offer): ?>
      <div class="card my-2">
        <div class="row mx-0">
          <div class="col-md-2 p-4">
            <div class="bg-body-tertiary w-100 h-100 d-flex justify-content-center align-items-center">
              <img class="img-fluid rounded-start" width="250px"  src="<?php echo $offer['image_link']; ?>">
            </div>
          </div>
          <div class="col-md-10">
            <div class="row mt-2 row-cols-auto">
              <div class=" ms-auto"></div>
              <span class="text-secondary fs-6"><i class="bi bi-hourglass-bottom me-1"></i> <?php echo $offer['end_datetime']->format('d/M/Y'); ?></span>
              <?php
              $difference = $offer['creation_datetime']->diff($datetime_now);
              ?>
              <span class="text-secondary fs-6"><i class="bi bi-clock me-1"></i>hace <?php echo $difference->h; ?>h, <?php echo $difference->i; ?>m</span>
              <?php if ($offer['availability'] == 'OFFLINE') : ?>
                <span class="text-secondary fs-6"><i class="bi bi-geo-alt"></i>Local</span>
              <?php endif; ?>
            </div>
            <div class="row">
              <h5 class="text-start"><?php echo $offer['title'] ?></h5>
            </div>
            <div class="row row-cols-auto">
              <div class="col-md-12">
                <span class="text-success fw-bolder fs-5">$<?php echo number_format($offer['offer_price'], 2); ?></span>
                <?php if ($offer['regular_price'] != null && $offer['regular_price'] != 0): ?>
                  <span class="text-secondary fs-5 text-decoration-line-through">
                    $<?php echo number_format($offer['regular_price'], 2); ?>
                  </span>
                  <span class="text-secondary fs-5 text-decoration-line-through">
                    -<?php echo floor($offer['offer_price'] / $offer['regular_price'] * 100); ?>%
                  </span> 
                <?php endif; ?>
                <?php if (isset($offer['shipping_cost']) && $offer['availability'] == 'ONLINE'): ?>
                  <span class="text-secondary fs-4 ms-1">
                    <i class="bi bi-truck"></i>
                  </span>
                  <span class="text-secondary fs-6 me-1">
                    <?php if ($offer['shipping_cost'] == 0): ?>
                      Envío gratis
                    <?php else: ?>
                      $<?php echo $offer['shipping_cost']; ?>
                    <?php endif; ?>
                  </span>
                  <?php endif; ?>
                  <?php if ($offer['availability' ] == 'OFFLINE'): ?>
                    <span class="text-secondary fs-5"><i class="bi bi-shop mx-1"></i>Local</span>
                  <?php endif; ?>
                <span class="text-secondary fs-5">|</span>
                <a class="fs-6 text-decoration-none" href="#"><?php echo $offer['store']; ?></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <p class="lh-sm text-break align-bottom"><?php
                  echo substr($offer['description'], 0, 300); 
                  if (strlen($offer['description']) > 300) {
                    echo '...';   
                  }
                ?></p>
              </div>
            </div>
            <div class="row pb-2 align-items-center">
              <div class="col-md-12 d-flex justify-content-between">
                <div >
                  <a class="fw-semibold align-middle text-decoration-none text-dark" href="#">
                    <img src="assets/images/user.png" class="rounded-circle border" height="22" alt="Avatar" loading="lazy"/>
                    <?php echo $offer['creator_username'];?>
                  </a>
                </div>
                <div>
                  <button class="btn text-secondary border border-secondary rounded-5 btn-outline-light"><i class="bi bi-bookmark"></i></button>
                  <button class="btn text-secondary border border-secondary rounded-5 btn-outline-light"><i class="bi bi-chat-square-text"></i> <?php echo $offer['comment_count']; ?></button>
                  <a class="btn btn-success rounded-5" href="<?php echo '/offers/offer.php?id=' . $offer['deal_id'] ?>">Ir a la oferta <i class="bi bi-box-arrow-up-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''?>">
          <?php $prevPage = $page - 1;?>
          <a class="page-link" href='index.php?<?php echo "mode=$mode&page={$prevPage}" ?>'>Previous</a>
        </li>
        <?php
        for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
          if ($pagina == $paginaActual) {
              echo '<li class="page-item active"><a class="page-link" href="index.php?mode='. $mode . '&page='. $page. '">'. $pagina .'</a></li>';
          } else {
              echo "<li class='page-item'><a class='page-link' href='index.php?mode=$mode&page=$pagina'>$pagina</a></li>";
          }
        }
        ?>
        <li class="page-item <?php echo $page >= $totalPaginas ? 'disabled' : ''?>">
          <?php $nextPage = $page + 1;?>
          <a class="page-link" href='index.php?<?php echo "mode=$mode&page={$nextPage}"; ?>'>Next</a>
        </li>
      </ul>
    </nav>
  </div>
</div>

<script>
        function scrollLeft() {
            document.getElementById('categoriasBar').scrollBy({
                left: -200, // Adjust the value to scroll more or less
                behavior: 'smooth'
            });
        }
        function scrollRight() {
            document.getElementById('categoriasBar').scrollBy({
                left: 200, // Adjust the value to scroll more or less
                behavior: 'smooth'
            });
        }
    </script>

<?php include 'shared/footer.php' ?>