<?php
ini_set('display_errors', E_ALL);

?>

<?php include 'shared/header.php' ?>

<?php
$categorias = array(
  'Tecnología',
  'Videojuegos',
  'Abarrotes y alimentos',
  'Ropa y accesorios',
  'Salud y belleza',
  'Familía, bebés y niños',
  'Hogar',
  'Jardín y hazlo tú mismo',
  'Autos y motos',
  'Entrenamiento y tiempo libre',
  'Deportes y ejercicio',
  'Internet y telefonía celular',
  'Viajes',
  'Finanzas y seguros',
  'Servicios y suscripciones',
  'Gratis'
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

);

$promos = [$promo1, $promo2];

?>

<div>
  <div style="display: flex;" class="categorias-bar">
    <?php foreach ($categorias as &$categoria): ?>
      <div style="categoria">
        <?php echo $categoria; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="filter-bar">
    <div class="right-bar">
      <div>Para ti</div>
      <div>Hot</div>
      <div>Nuevas</div>
    </div>
  </div>
  <div class="ofertas">
    <?php foreach ($promos as &$promo): ?>
      <table class="oferta" width="100%">
        <tbody>
          <tr>
            <td rowspan="5">
              <img width="200px" src="<?php echo $promo['img'] ?>">
            </td>
            <td colspan="4">
              <div class="oferta-top">
                <p style="text-align: right;">
                  <?php $difference = $date1->diff($date2); ?>
                  hace <?php echo $difference->h; ?>h, <?php echo $difference->i; ?>m
                </p>
              </div>
            </td>

          </tr>
          <tr>
            <td colspan="4">
              <div class="oferta-title">
                <a href="offer.php?id=<?php echo $promo['id_post']; ?>">
                  <h4><?php echo $promo['title'] ?></h4>
                </a>
              </div>
            </td>
          </tr>
          <tr>

            <td>
              <div class="oferta-info" style="display: flex;">
                <span class="actual-price"><?php echo $promo['actual_price']; ?></span>
                <?php if ($promo['previous_price'] != null && $promo['previous_price'] != 0): ?>
                  <span class="older-price" style="text-decoration: dashed;"><?php echo $promo['previous_price']; ?></span>
                  <span
                    class="descuento-price"><?php echo $promo['actual_price'] / $promo['previous_price'] * 100; ?></span>
                <?php endif; ?>
                <span
                  class="delivery-cost"><?php echo $promo['delivery_price'] == 0 ? 'Envio gratis' : $promo['delivery_price']; ?></span>
                <span class="shop"><?php echo $promo['shop']; ?></span>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <div class="oferta-desc">
                <?php echo $promo['description']; ?>
              </div>

            </td>
          </tr>
          <tr>
            <td colspan="4">
              <div class="promo-actions">
                <div class="publisher-img">
                  <img>
                  <span><?php echo $promo['publisher']; ?></span>
                </div>
                <button>Guardar</button>
                <button>comentarios</button>
                <a href="<?php echo $promo['url']; ?>">
                  <button>Ir a la oferta</button>

                </a>
              </div>

            </td>
          </tr>
        </tbody>
      </table>
    <?php endforeach; ?>
  </div>
</div>

<script>
  document.
</script>

<?php include 'shared/footer.php' ?>