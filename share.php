<?php
ini_set('display_errors', E_ALL);
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$usuario = $_SESSION['user'];

$categories = array(
  'Tecnología' => 15,
  'Videojuegos' => 1,
  'Abarrotes y alimentos' => 2,
  'Ropa y accesorios' => 3,
  'Salud y belleza' => 4,
  'Familía, bebés y niños' => 5,
  'Hogar' => 6,
  'Jardín y hazlo tú mismo' => 7,
  'Autos y motos' => 8,
  'Entrenamiento y tiempo libre' => 9,
  'Deportes y ejercicio' => 10,
  'Internet y telefonía celular' => 11,
  'Viajes' => 12,
  'Finanzas y seguros' => 13,
  'Servicios y suscripciones' => 14,
);
?>

<?php $title = 'Compartir promoción' ?>
<?php include 'shared/header.php'; ?>

<div class="container mt-2">
  <div class="card p-4">
      <h2 class="mb-4">Comparte una oferta con millones de personas</h2>
      <form method="POST" action="create_offer.php" enctype="multipart/form-data" class="card-body">
        <div class="row g-0">
            <div class="col-md-4" >
                <div class="p-3">
                    <label for="image" class="form-label">Imagen</label>
                    <div  id="imagePreviewContainer" class="bg-body-tertiary d-flex justify-content-center align-items-center my-2">
                        <img id="imagePreview" src="assets/images/no_img.jpg" alt="Previsualización de la imagen" class="img-fluid rounded-start">
                    </div>
                    <input type="file" id="image" name="image" class="form-control" accept="image/png, image/jpeg" required/>
                </div>
            </div>
            <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="title" class="form-label">Titulo</label>
                      <input type="text" id="title" name="title" class="form-control" required minlength="4" maxlength="140" placeholder="Incluye tienda y artículo o promoción"/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                        <label for="url" class="form-label">Enlace de la oferta</label>
                        <input type="url" id="url" name="url" class="form-control" required/>
                    </div>
                    <div class="col-md-4">
                            <label for="category" class="form-label">Categoria</label>
                            <select id="category" name="category" class="form-select">
                                <option disabled selected>Selecciona una categoria...</option>
                                <?php foreach ($categories as $category => $id): ?>
                                      <option value="<?php echo $id; ?>"><?php echo $category; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <label for="store" class="form-label">Tienda</label>
                        <input type="text" id="store" name="store" class="form-control" required minlength="1" maxlength="50"/>
                    </div>
                    <div class="col-md-6">
                        <label for="cupon" class="form-label">Cupon</label>
                        <input type="text" id="cupon" name="cupon" class="form-control" maxlength="50" placeholder="Código a utilizar para obtener el descuento"/>
                    </div>
                  </div>
                        <div class="row">
                          <div class="mb-3 col-md-6">
                              <label for="offer-price" class="form-label">Precio en oferta</label>
                              <input type="number" id="offer-price" name="offerPrice" class="form-control" min="0"/>
                          </div>
                          <div class="mb-3 col-md-6">
                              <label for="normal-price" class="form-label">Precio regular</label>
                              <input type="number" id="normal-price" name="normalPrice" class="form-control" min="0"/>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="availability" id="online" value="online" checked>
                                  <label class="form-check-label" for="online">Online</label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="availability" id="offline" value="offline">
                                  <label class="form-check-label" for="offline">Tienda física</label>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                  
                        <div id="shippingDetails" class="row">
                            <div class="col-md-6">
                                <label for="shipping-cost" class="form-label">Costo de envio</label>
                                <input type="number" id="shipping-cost" name="shippingCost" class="form-control" min="0"/>
                            </div>
                            <div class="col-md-6">
                                <label for="shipping-address" class="form-label">Se envia desde</label>
                                <input type="text" id="shipping-address" name="shippingAddress" class="form-control" minlength="2" maxlength="50"/>
                            </div>
                        </div>
                        <div class="row">

                          <div class="col-md-12">
                              <label for="description" class="form-label">¿Por qué vale la pena compartir esta oferta?</label>
                              <textarea id="description" name="description" class="form-control" placeholder="Si es en tienda física menciona qué sucursal e incluye una foto
  Si es por internet, incluye el link
  
  Por favor evita mayúsculas
  
  Describe la oferta con tus propias palabras y comparte con la comunidad por qué vale la pena esta promoción.
  
  Si no ves la tuya, puedes ser por una de estas razones: duplicado, promoción personal, links de referidos, no hay inventario, no es oferta, es un concurso (al menos que sea uno en el que todos ganan)" required minlength="1" maxlength="1000"></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                              <label for="start-date" class="form-label">¿Cuando comienza?</label>
                              <input type="date" id="start-date" name="startDate" class="form-control"/>
                          </div>
                          <div class="col-md-3">
                              <label for="start-time" class="form-label">Hora inicio</label>
                              <input type="time" id="start-time" name="startTime" class="form-control"/>
                          </div>
                          <div class="col-md-3">
                              <label for="end-date" class="form-label">¿Cuando termina?</label>
                              <input type="date" id="end-date" name="endDate" class="form-control"/>
                          </div>
                          <div class="col-md-3">
                              <label for="end-time" class="form-label">Hora fin</label>
                              <input type="time" id="end-time" name="endTime" class="form-control"/>
                          </div>

                        </div>
                        <div class="row">
                          <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                                </row>
                  </div>
                </form>
                </div>
</div>
<?php include 'shared/footer.php'; ?>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
    });

    document.getElementById('online').addEventListener('change', function() {
        document.getElementById('shippingDetails').style.display = 'block';
    });

    document.getElementById('offline').addEventListener('change', function() {
        document.getElementById('shippingDetails').style.display = 'none';
    });

    // Ocultar los detalles de envío por defecto si la opción "offline" está seleccionada al cargar la página
    window.addEventListener('load', function() {
        if (document.getElementById('offline').checked) {
            document.getElementById('shippingDetails').style.display = 'none';
        }
    });
</script>
