<?php
ini_set('display_errors', E_ALL);
include_once '../utils.php';
include_once '../config.php';
include_once '../Database.php';



session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../auth/login.php');
  exit;
}

$data = sanitize_input($_GET, array('id' => 'int'));
$id = $data['id'];

$mode = 'new';
if (isset($id)) {

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

    

    $res->free_result();
    $database->closeConnection();
    if (!isset($offer['deal_id'])) {
      header('Location: ../shared/errors/404.php');
      exit;
    }
    if ($offer['creator_user_id'] == $_SESSION['user_id']) {
      $mode = 'edit';
    }
  } catch (mysqli_sql_exception $e) {
    header('Location: ../shared/errors/500.php');
    exit;
  }
}

$usuario = $_SESSION['user'];

$categories = array(
  'Tecnología' => 15,
  'Videojuegos' => 1,
  'Abarrotes y alimentos' => 2,
  'Ropa y accesorios' => 3,
  'Salud y belleza' => 4,
  'Familia, bebés y niños' => 5,
  'Hogar' => 6,
  'Jardín y hazlo tú mismo' => 7,
  'Autos y motos' => 8,
  'Entretenimientos y tiempo libre' => 9,
  'Deportes y ejercicio' => 10,
  'Internet y telefonía celular' => 11,
  'Viajes' => 12,
  'Finanzas y seguros' => 13,
  'Servicios y suscripciones' => 14,
);
?>

<?php $title = 'Compartir promoción' ?>
<?php include '../shared/header.php';?>



<div class="container mt-4">
  <div class="card p-4">
      <h2 class="mb-4">Comparte una oferta con millones de personas</h2>
      <form method="POST" <?php echo $mode == 'new' ? 'action="actions/create_offer.php"' : 'action="actions/edit_offer.php"'; ?> enctype="multipart/form-data" class="card-body">
        <?php if ($mode != 'new'): ?>
          <input type="hidden" name="id" value="<?php echo $offer['deal_id'] ?>" />
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3">
                    <label for="image" class="form-label">Imagen</label>
                    <div id="imagePreviewContainer" class="bg-body-tertiary d-flex justify-content-center align-items-center my-2 border rounded" style="height: 200px;">
                        <img id="imagePreview" src="<?php echo $mode == 'new' ? '/assets/images/no_img.jpg' : $offer['image_link']; ?>" alt="Previsualización de la imagen" class="img-fluid rounded-start" style="max-height: 100%;">
                    </div>
                    <div class="d-grid">
                      <?php if ($mode == 'edit'): ?>
                        <button id="change-image-btn" class="btn btn-outline-primary" onclick="changeImage(event)" >Cambiar imagen</button>
                        <input type="text" id="image" name="image" class="form-control" hidden value="<?php echo $offer['image_link']?>"/>
                      <?php endif; ?>
                      <input type="file" id="image-file-input" name="image" class="form-control" accept="image/png, image/jpeg" <?php echo $mode == 'edit' ? "hidden" : "required" ?>/>
                      <div class="valid-feedback">
                        ¡Es una foto perfecta!
                      </div>
                      <div class="invalid-feedback" id="user-invalid">
                        Esa imagen tiene algo raro...
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="title" class="form-label">Título</label>
                      <input type="text" id="title" name="title" class="form-control" required minlength="4" maxlength="140" placeholder="Incluye tienda y artículo o promoción" value="<?php echo $mode == 'new' ? '' : $offer['title']; ?>" />
                      <div class="valid-feedback">
                        ¡Ese titulo es perfecto!
                      </div>
                      <div class="invalid-feedback" id="user-invalid">
                        Lo sentimos, los titulos tienen que tener entre 4 y 140 caracteres.
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                        <label for="url" class="form-label">Enlace de la oferta</label>
                        <input type="url" id="url" name="url" class="form-control" required value="<?php echo $mode == 'new' ? '' : $offer['link']; ?>"/>
                    </div>
                    <div class="col-md-4">
                            <label for="category" class="form-label">Categoría</label>
                            <select id="category" name="category" class="form-select">
                                <option disabled selected>Selecciona una categoría...</option>
                                <?php foreach ($categories as $category => $id): ?>
                                      <option value="<?php echo $id; ?>" <?php echo $mode != 'new' && $offer['category_name'] == $category ? 'selected' : ''; ?>><?php echo $category; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                        <label for="store" class="form-label">Tienda</label>
                        <input type="text" id="store" name="store" class="form-control" required minlength="1" maxlength="50" value="<?php echo $mode == 'new' ? '' : $offer['store']; ?>"/>
                        <div class="valid-feedback">
                          ¡Esa es muy buena tienda!
                        </div>
                        <div class="invalid-feedback" id="user-invalid">
                          Los valores solos pueden ser alfanumericos.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="cupon" class="form-label">Cupón</label>
                        <input type="text" id="cupon" name="cupon" class="form-control" maxlength="50" placeholder="Código a utilizar para obtener el descuento" value="<?php echo $mode == 'new' ? '' : $offer['coupon_code']; ?>"/>
                        <div class="valid-feedback">
                          ¡Ese es un buen cupón!
                        </div>
                        <div class="invalid-feedback" id="user-invalid">
                          Tal vez ese cupon sea muy largo, mejor que sea de 50 caracteres.
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="offer-price" class="form-label">Precio en oferta</label>
                        <input type="number" id="offer-price" name="offerPrice" class="form-control" min="0" step=".01" value="<?php echo $mode == 'new' ? '' : $offer['offer_price']; ?>"/>
                        <div class="valid-feedback">
                          ¡Oferton!
                        </div>
                        <div class="invalid-feedback" id="user-invalid">
                          Un puede ser negativo.
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="normal-price" class="form-label">Precio regular</label>
                        <input type="number" id="normal-price" name="normalPrice" class="form-control" min="0" step=".01" value="<?php echo $mode == 'new' ? '' : $offer['regular_price']; ?>"/>
                        <div class="valid-feedback">
                              Sí que estaba cariñoso...
                          </div>
                        <div class="invalid-feedback" id="user-invalid">
                          Un puede ser negativo.
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="availability" id="online" value="online" <?php echo $mode == 'new' ? 'checked' : ''; ?> <?php echo $mode != 'new' && $offer['availability'] == 'ONLINE' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="online">Online</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="availability" id="offline" value="offline" <?php echo $mode != 'new' && $offer['availability'] == 'OFFLINE' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="offline">Tienda física</label>
                        </div>
                    </div>
                  </div>
                    <div id="shippingDetails" class="row">
                        <div class="col-md-6">
                            <label for="shipping-cost" class="form-label">Costo de envío</label>
                            <input type="number" id="shipping-cost" name="shippingCost" class="form-control" min="0" value="<?php echo $mode == 'new' ? '' : $offer['shipping_cost']; ?>"/>
                            <div class="valid-feedback">
                              Espero que sea el mismo para todos
                            </div>
                            <div class="invalid-feedback" id="user-invalid">
                              Un puede ser negativo.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="shipping-address" class="form-label">Se envía desde</label>
                            <input type="text" id="shipping-address" name="shippingAddress" class="form-control" minlength="2" maxlength="50" value="<?php echo $mode == 'new' ? '' : $offer['shipping_address']; ?>"/>
                            <div class="valid-feedback">
                              ¡Ese lugar es maravilloso!
                            </div>
                            <div class="invalid-feedback" id="user-invalid">
                              Solo puede tener entre 2 y 50 caracteres.
                            </div>
                        </div>
                    </div>
                  <div class="row">
                    <div class="col-md-12">
                        <label for="description" class="form-label">¿Por qué vale la pena compartir esta oferta?</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Describe la oferta con tus propias palabras y comparte con la comunidad por qué vale la pena esta promoción." required minlength="1" maxlength="1000"><?php echo $mode == 'new' ? '' : $offer['description']; ?></textarea>
                        <div class="valid-feedback">
                          Es un buen motivo.
                        </div>
                        <div class="invalid-feedback" id="user-invalid">
                          La descripción debe tener entre 2 y 1000 caracteres.
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                        <label for="start-date" class="form-label">¿Cuándo comienza?</label>
                        <input type="date" id="start-date" name="startDate" class="form-control" value="<?php echo $mode == 'new' ? '' : $offer['start_date']; ?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="start-time" class="form-label">Hora inicio</label>
                        <input type="time" id="start-time" name="startTime" class="form-control" value="<?php echo $mode == 'new' ? '' : $offer['start_time']; ?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="end-date" class="form-label">¿Cuándo termina?</label>
                        <input type="date" id="end-date" name="endDate" class="form-control" value="<?php echo $mode == 'new' ? '' : $offer['end_date']; ?>" />
                    </div>
                    <div class="col-md-3">
                        <label for="end-time" class="form-label">Hora fin</label>
                        <input type="time" id="end-time" name="endTime" class="form-control" value="<?php echo $mode == 'new' ? '' : $offer['end_time']; ?>" />
                    </div>
                  </div>
                  <div class="row mt-3">
                    <button type="submit" class="btn btn-primary" id="submitButton" <?php echo $mode == 'new' ? 'disabled' : '';?>>Enviar</button>
                  </div>
            </div>
        </div>
      </form>
  </div>
</div>

<?php include '../shared/footer.php'; ?>


<script>
  <?php if ($mode == 'edit'): ?>
    function changeImage(event) {
      event.preventDefault();
            document.getElementById('change-image-btn').hidden = true;
            document.getElementById('image-file-input').hidden = false;
        }
  <?php endif; ?>


    document.getElementById('image-file-input').addEventListener('change', function(event) {
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

    on_load = () => {
      var success_form = false;
      var invalid_email = document.getElementById('email-invalid');
      var invalid_user = document.getElementById('user-invalid');

      // Expresión regular para validar el formato de email
      
      function isValidImage(image) {
        return image != '' ? true : false;
      }


      function isValidUrl(url) {
          var urlRegex = /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
          return urlRegex.test(url);
      }
      function isValidCategory(category) {
          
          return typeof category === 'string' && category != '';
      }
      function isValidCupon(category) {
          var categoryRegex = /^.{1,255}$/;
          return categoryRegex.test(category);
      }
      function isValidOfferPrice(category) {
          var categoryRegex = /^(?:0|[1-9]\d*)(?:\.\d{1,2})?$|^$/;
          return categoryRegex.test(category);
      }
      function isValidNormalPrice(category) {
          var categoryRegex = /^(?:0|[1-9]\d*)(?:\.\d{1,2})?$|^$/;
          return categoryRegex.test(category);
      }
      function isValidShippingCost(category) {
          var categoryRegex = /^(?:0|[1-9]\d*)(?:\.\d{1,2})?$|^$/;
          return categoryRegex.test(category);
      }
      function isValidTitle(title) {
          var titleRegex = /^.{4,140}$/;
          return titleRegex.test(title);
      }
      function isValidStore(store) {
          var storeRegex = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]{1,50}$/;
          return storeRegex.test(store);
      }
      function isValidDescription(description) {
          var descriptionRegex = /^.{1,1000}$/;
          return descriptionRegex.test(description);
      }
      function isValidShippingAddress(address) {
          var shippingRegex = /^.{2,50}$/;
          return shippingRegex.test(address);
      }
      function isValidStartDate(date) {
          var startDateRegex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
          return startDateRegex.test(date);
      }
      function isValidEndDate(date) {
          var endDateRegex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
          return endDateRegex.test(date);
      }
      function isValidStartTime(time) {
          var startTimeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/;
          return startTimeRegex.test(time);
      }
      function isValidEndTime(time) {
          var endTimeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/;
          return endTimeRegex.test(time);
      }

      function validateImage() {
          var image = $('#image-file-input').val();
          if (image !== '' && isValidImage(image)) {
              $('#image-file-input').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#image-file-input').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateTitle() {
          var title = $('#title').val();
          if (title !== '' && isValidTitle(title)) {
              $('#title').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#title').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateCupon() {
          var cupon = $('#cupon').val();
          if (cupon == '' || isValidCupon(cupon)) {
              if (cupon == '') {
                $('#cupon').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#cupon').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#cupon').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateOfferPrice() {
          var offerPrice = $('#offer-price').val();
          if (offerPrice == '' || isValidCupon(offerPrice) && !offerPrice.startsWith('-')) {
              if (offerPrice == '') {
                $('#offer-price').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#offer-price').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#offer-price').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateNormalPrice() {
          var normalPrice = $('#normal-price').val();
          if (normalPrice == '' || isValidCupon(normalPrice) && !normalPrice.startsWith('-')) {
              if (normalPrice == '') {
                $('#normal-price').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#normal-price').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#normal-price').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateShippingCost() {
          var shippingCost = $('#shipping-cost').val();
          if (shippingCost == '' || isValidCupon(shippingCost) && !shippingCost.startsWith('-')) {
              if (shippingCost == '') {
                $('#shipping-cost').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#shipping-cost').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#shipping-cost').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateShippingAddress() {
          var shippingAddress = $('#shipping-address').val();
          if (shippingAddress == '' || isValidShippingAddress(shippingAddress)) {
              if (shippingAddress == '') {
                $('#shipping-address').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#shipping-address').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#shipping-address').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateDescription() {
          var description = $('#description').val();
          if (description !== '' && isValidCupon(description)) {
              $('#description').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#description').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateStartDate() {
          var date = $('#start-date').val();
          if (date == '' || isValidCupon(date)) {
              if (date == '') {
                $('#start-date').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#start-date').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#start-date').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateEndDate() {
          var date = $('#end-date').val();
          if (date == '' || isValidCupon(date)) {
              if (date == '') {
                $('#end-date').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#end-date').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#end-date').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateStartTime() {
          var time = $('#start-time').val();
          if (time == '' || isValidCupon(time)) {
              if (time == '') {
                $('#start-time').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#start-time').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#start-time').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateEndTime() {
          var time = $('#end-time').val();
          if (time == '' || isValidEndTime(time)) {
              if (time == '') {
                $('#end-time').removeClass('is-valid').removeClass('is-invalid');
                return;
              }
              $('#end-time').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#end-time').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateUrl() {
          var time = $('#url').val();
          if (time !== '' && isValidUrl(time)) {
              $('#url').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#url').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateCategory() {
          var time = $('#category').val();
          console.log(time)
          if (time !== '' && isValidCategory(time)) {
              $('#category').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#category').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }
      function validateStore() {
          var time = $('#store').val();
          if (time !== '' && isValidStore(time)) {
              $('#store').removeClass('is-invalid').addClass('is-valid');
              validateSubmitButton();
          } else {
              $('#store').removeClass('is-valid').addClass('is-invalid');
              validateSubmitButton();
          }
      }

      // Función para habilitar o deshabilitar el botón de submit
      function validateSubmitButton() {
          var isValidUrl = $('#url').hasClass('is-valid');
          var isValidCategory = $('#category').hasClass('is-valid');
          var isValidCupon = $('#cupon').hasClass('is-valid');
          var isValidDescription = $('#description').hasClass('is-valid');
          var isValidImage = $('#description').hasClass('is-valid');

          var isValidOfferPrice = $('#offer-price').hasClass('is-invalid') ? false : true;
          var isValidNormalPrice = $('#normal-price').hasClass('is-invalid') ? false : true;;
          var isValidShippingCost = $('#shipping-cost').hasClass('is-invalid') ? false : true;;
          var isValidShippingAddress = $('#shipping-address').hasClass('is-invalid') ? false : true;;
          var isValidStartDate = $('#start-date').hasClass('is-invalid') ? false : true;
          var isValidEndDate = $('#end-date').hasClass('is-invalid') ? false : true;
          var isValidStartTime = $('#start-time').hasClass('is-invalid') ? false : true;
          var isValidEndTime = $('#end-time').hasClass('is-invalid') ? false : true;
          var isValidStore = $('#store').hasClass('is-invalid') ? false : true;

          if (
            isValidUrl &&
            isValidCategory &&
            isValidDescription &&
            isValidStore &&
            isValidImage &&

            isValidShippingCost &&
            isValidShippingAddress &&
            isValidStartDate &&
            isValidEndDate &&
            isValidStartTime &&
            isValidEndTime &&
            isValidOfferPrice &&
            isValidNormalPrice
          ) {
              $('#submitButton').prop('disabled', false);
          } else {
              $('#submitButton').prop('disabled', true);
          }
      }

      $('#title').on('keyup focusout', function () {
          validateTitle();
        });
      $('#store').on('keyup focusout', function () {
          validateStore();
        });
      $('#url').on('keyup focusout', function () {
          validateUrl();
        });
      $('#category').on('change focusout', function () {
          validateCategory();
        });
      $('#image-file-input').on('change focusout', function () {
          validateImage();
        });

      $('#cupon').on('keyup', function () {
          validateCupon();
        });
      $('#offer-price').on('keyup', function () {
          validateOfferPrice();
        });
      $('#normal-price').on('keyup', function () {
          validateNormalPrice();
        });
      $('#shipping-cost').on('keyup', function () {
          validateShippingCost();
        });
      $('#shipping-address').on('keyup', function () {
          validateShippingAddress();
        });
      $('#description').on('keyup', function () {
          validateDescription();
        });
      $('#start-date').on('keyup change', function () {
          validateStartDate();
        });
      $('#end-date').on('keyup change', function () {
          validateEndDate();
        });
      $('#start-time').on('keyup change', function () {
          validateStartTime();
        });
      $('#end-time').on('keyup change', function () {
          validateEndTime();
        });
      
        <?php if ($mode != 'new'): ?>
          const inputs = document.querySelectorAll('input');
          const desc = document.getElementById('description');
          const cat = document.getElementById('category');
          desc.classList.add('is-valid');
          cat.classList.add('is-valid');
          inputs.forEach(input => {
              if (input.value.trim() !== "") {
                  input.classList.add('is-valid');
              }
          });
        <?php endif; ?>
    }
</script>

