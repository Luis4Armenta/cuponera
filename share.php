<?php
ini_set('display_errors', E_ALL);
session_start();
if(!isset($_SESSION['user'])) {
  Header('Location: login.php');
  exit;
}

$usuario = $_SESSION['user'];

$categories = array(
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
?>
<div>
  <h2>Comparte una oferta con millones de personas</h2>
  <form method="POST" action="create_offer.php">
    <div>
      <label for="url">Enlace de la oferta</label>
      <input type="url" id="url" name="url" required/>
    </div>
    <div>
      <label for="title">Titulo</label>
      <input type="text" id="title" name="title" required minlength="4" maxlength="140" placeholder="Incluye tienda y artículo o promoción"/>
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
        <?php foreach ($categories as &$category): ?>
          <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <input type="submit" value="Enviar" />
  </form>
</div>