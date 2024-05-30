<?php
$id = $_GET['id'];
if (!isset($_GET['id'])) {
  header('Location: index.html');
  exit;
}

$date1 = new DateTime();
$interval = new DateInterval('PT2H15M');
$date2 = clone $date1;
$date2->add($interval);


$promo = array(
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


include 'shared/header.php';
?>

<div class="container">
  <div class="row">
    <div class="card mb-3">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="<?php echo $promo['img']; ?>" class="img-fluid rounded-start" alt="Imagen del articulo/servicio">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"><?php echo $promo['title']; ?></h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
              content. This content is a little bit longer.</p>
            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include 'shared/footer.php'; ?>