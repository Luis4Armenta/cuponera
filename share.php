<?php
ini_set('display_errors', E_ALL);
session_start();
if(!isset($_SESSION['user'])) {
  Header('Location: login.php');
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

<?php include 'shared/header.php'; ?>
<div>
  <h2>Comparte una oferta con millones de personas</h2>
  <form method="POST" action="create_offer.php" enctype="multipart/form-data">
    <div>
      <label for="url">Enlace de la oferta</label>
      <input type="url" id="url" name="url" required/>
    </div>
    <div>
      <label for="title">Titulo</label>
      <input type="text" id="title" name="title" required minlength="4" maxlength="140" placeholder="Incluye tienda y artículo o promoción"/>
    </div>
    <div>
      <label for="store">Tienda</label>
      <input type="text" id="store" name="store" required minlength="1" maxlength="50"/>
    </div>
    <div>
      <label for="image">Imagen</label>
      <input type="file" id="image" name="image" accept="image/png, image/jpeg" required/>
    </div>
    <div>
      <label for="offer-price">Precio en oferta</label>
      <input type="number" id="offer-price" name="offerPrice" min="0" required/>
    </div>
    <div>
      <label for="normal-price">Precio regular</label>
      <input type="number" id="normal-price" name="normalPrice" min="0" required/>
    </div>
    <div>
      <label for="cupon">Cupon</label>
      <input type="text" id="cupon" name="cupon" maxlength="50" placeholder="Código a utilizar para obtener el descuento"/>
    </div>
    <div>
      <input type="radio" class="btn-check" name="availability" id="success-outlined" autocomplete="off" checked value="online">
      <label class="btn btn-outline-success" for="success-outlined">Online</label>

      <input type="radio" class="btn-check" name="availability" id="danger-outlined" autocomplete="off" value="offline">
      <label class="btn btn-outline-danger" for="danger-outlined">Tienda física</label>
      <!-- Si es online debe aparecer esto -->
      <div>
        <div>
          <label for="shipping-cost">Costo de envio</label>
          <input type="number" id="shipping-cost" name="shippingCost" value="0" min="0"/>
        </div>
        <div>
          <label for="shipping-address">Se envia desde</label>
          <input type="text" id="shipping-address" name="shippingAddress" minlength="2" maxlength="50" value=""/>
        </div>
      </div>
    </div>
    <div>
      <label for="description">¿Por qué vale la pena compartir esta oferta?</label>
      <textarea id="description" name="description" placeholder="Si es en tienda física menciona qué sucursal e incluye una foto
Si es por internet, incluye el link


Por favor evita mayúsculas

Describe la oferta con tus propias palabras y comparte con la comunidad por qué vale la pena esta promoción.

Si no ves la tuya, puedes ser por una de estas razones: duplicado, promoción personal, links de referidos, no hay inventario, no es oferta, es un concurso (al menos que sea uno en el que todos ganan)" required minlength="1" maxlength="1000"></textarea>
    </div>
    <div>
      <label for="start-date">¿Cuando comienza?</label>
      <input type="date" id="start-date" name="startDate"/>
    </div>
    <div>
      <label for="start-date">Hora inicio</label>
      <input type="time" id="start-time" name="startTime"/>
    </div>
    <div>
      <label for="end-date">¿Cuando termina?</label>
      <input type="date" id="end-date" name="endDate"/>
    </div>
    <div>
      <label for="end-date">Hora fin</label>
      <input type="time" id="end-time" name="endTime"/>
    </div>
    <div>
      <label for="category">Categoria</label>
      <select id="category" name="category">
        <option disabled selected>
          Selecciona una categoria...
        </option>
        <?php foreach ($categories as $category => $id): ?>
          <option value="<?php echo $id; ?>"><?php echo $category; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <input type="submit" value="Enviar" />
  </form>
</div>
<?php include 'shared/footer.php'; ?>
