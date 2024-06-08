<?php
ini_set('display_errors', E_ALL);
session_start();

?>

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
$date1 = new DateTime();
$interval = new DateInterval('PT2H15M');
$date2 = clone $date1;
$date2->add($interval);

$promo1 = array(
  'id_post' => '1',
  'title' => 'CyberPuerta - XFX Speedster SWFT 210 RX 6650 XT',
  'actual_price' => 4369,
  'previous_price' => null,
  'delivery_price' => '$128',
  'shop' => 'CyberPuerta',
  'publisher' => 'Javier Sanchez',
  'img' => 'https://static.promodescuentos.com/threads/raw/XMIag/959012_1/re/1024x1024/qt/60/959012_1.jpg',
  'description' => 'Potencia 550w',
  'num_comments' => 40,
  'url' => 'https://www.cyberpuerta.mx/Computo-Hardware/Componentes/Tarjetas-de-Video/Tarjeta-de-Video-XFX-Speedster-SWFT-210-AMD-Radeon-RX-6650-XT-8GB-128-bit-GDDR6-PCI-Express-4-0.html',
  'publication_date' => $date2,
  'expiration_datetime' => $date1,
  'shipping_cost' => 87,
  'comments_num'=> 42,

);
$promo2 = array(
  'id_post' => '2',
  'title' => 'Amazon: Escritorio minimalista $799 con Cupón del vendedor.',
  'actual_price' => 799,
  'previous_price' => 899,
  'delivery_price' => 128,
  'shop' => 'Amazon',
  'publisher' => 'MICHRO99',
  'img' => 'https://static.promodescuentos.com/threads/raw/tCdbE/959041_1/re/1024x1024/qt/60/959041_1.jpg',
  'description' => 'Escritorio minimalista con almacenamiento y nivel para PC.  ',
  'num_comments' => 13,
  'url' => 'https://www.amazon.com.mx/dp/B0CR1F46M7',
  'publication_date' => $date2,
  'expiration_datetime' => $date1,
  'shipping_cost' => 0,
  'comments_num'=> 0,
);

$promos = [$promo1, $promo2];

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
    <?php foreach ($promos as &$promo): ?>
      <div class="card my-2">
        <div class="row mx-0">
          <div class="col-md-2 p-4">
            <div class="bg-body-tertiary w-100 h-100 d-flex justify-content-center align-items-center">
              <img class="img-fluid rounded-start" width="250px"  src="<?php echo $promo['img']; ?>">
            </div>
          </div>
          <div class="col-md-10">
            <div class="row mt-2 row-cols-auto">
              <div class=" ms-auto"></div>
              <span class="text-secondary fs-6"><i class="bi bi-hourglass-bottom me-1"></i> <?php echo $promo['expiration_datetime']->format('d/M/Y'); ?></span>
              <?php $difference = $date1->diff($date2); ?>
              <span class="text-secondary fs-6"><i class="bi bi-clock me-1"></i>hace <?php echo $difference->h; ?>h, <?php echo $difference->i; ?>m</span>

              <!-- <div class="col-md-1"><?php echo $promo['expiration_datetime']->format('d/M/Y'); ?></div>
              <?php $difference = $date1->diff($date2); ?>
              <div class="col-md-1">hace <?php echo $difference->h; ?>h, <?php echo $difference->i; ?>m</div> -->
            </div>
            <div class="row">
              <h5 class="text-start"><?php echo $promo['title'] ?></h5>
            </div>
            <div class="row row-cols-auto">
              <div class="col-md-12">
                <span class="text-success fw-bolder fs-5">$<?php echo $promo['actual_price']; ?></span>
                <?php if ($promo['previous_price'] != null && $promo['previous_price'] != 0): ?>
                  <span class="text-secondary fs-5 text-decoration-line-through">
                    $<?php echo $promo['previous_price']; ?>
                  </span>
                  <span class="text-secondary fs-5 text-decoration-line-through">
                    -<?php echo floor($promo['actual_price'] / $promo['previous_price'] * 100); ?>%
                  </span> 
                <?php endif; ?>
                <?php if (isset($promo['shipping_cost'])): ?>
                  <span class="text-secondary fs-4 ms-1">
                    <i class="bi bi-truck"></i>
                  </span>
                  <span class="text-secondary fs-6 me-1">
                    <?php if ($promo['shipping_cost'] == 0): ?>
                      Envío gratis
                    <?php else: ?>
                      $<?php echo $promo['shipping_cost']; ?>
                    <?php endif; ?>
                  </span>
                  
                <?php endif; ?>
                <span class="text-secondary fs-5">|</span>
                <a class="fs-6 text-decoration-none" href="#"><?php echo $promo['shop']; ?></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <p class="lh-sm text-break align-bottom"><?php echo $promo['description']; ?></p>
              </div>
            </div>
            <div class="row pb-2 align-items-center">
              <div class="col-md-12 d-flex justify-content-between">
                <div >
                  <a class="fw-semibold align-middle text-decoration-none text-dark" href="#">
                    <img src="assets/images/user.png" class="rounded-circle border" height="22" alt="Avatar" loading="lazy"/>
                    <?php echo $promo['publisher'];?>
                  </a>
                </div>
                <div>
                  <button class="btn text-secondary border border-secondary rounded-5 btn-outline-light"><i class="bi bi-bookmark"></i></button>
                  <button class="btn text-secondary border border-secondary rounded-5 btn-outline-light"><i class="bi bi-chat-square-text"></i> <?php echo $promo['comments_num']; ?></button>
                  <button class="btn btn-success rounded-5">Ir a la oferta <i class="bi bi-box-arrow-up-right"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
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