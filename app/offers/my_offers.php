<?php
ini_set('display_errors', E_ALL);
include_once '../config.php';
include_once '../Database.php';
include_once '../utils.php';

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../auth/login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

$offers = array(); 
try {
  $database = new Database();
  $db = $database->getConnection();
  $res = $db->query("SELECT deal_id, title, store, availability, c.name, end_time, end_date, timestamp FROM deals AS d LEFT JOIN categories AS c ON c.category_id = d.category_id WHERE user_id = {$user_id};");

  while ($registro = $res->fetch_row()) {
    // $end_datetime = new DateTime($registro[4]);
    // $creation_datetime = new DateTime($registro[5]);
    
    array_push($offers, array(
      'offer_id' => $registro[0],
      'title' => $registro[1],
      'store' => $registro[2],
      'availability' => $registro[3],
      'category' => $registro[4],
      'end_time' => $registro[5],
      'end_date' => $registro[6],
      'creation_datetime' => $registro[7],
    ));
  }

  $res->free_result();
  $database->closeConnection();
} catch (mysqli_sql_exception $e) {
  header('Location: shared/errors/500.php');
  exit;
}
?>

<?php $title = 'Mis promociones'; ?>
<?php include '../shared/header.php'; ?>

<div class="container">
  <div class="card mt-2 px-4">
    <div class="card-body">
      <div class="row text-center">
        <h1>Mis promociones</h1>
      </div>
      <div class="row">

        <table class="table table-striped" id="my_offers_table" style="width:100%">
          <thead class="table-light">
            <tr>
              <th scope="col" class="text-center">Titulo</th>
              <th scope="col" class="text-center">Tienda</th>
              <th scope="col" class="text-center">Disponibilidad</th>
              <th scope="col" class="text-center">Categoria</th>
              <th scope="col" class="text-center">Expira</th>
              <th scope="col" class="text-center">Estado</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($offers as &$offer): ?>
              <tr key="<?php echo $offer['offer_id']; ?>">
                <td><?php echo $offer['title']; ?></td>
                <td><?php echo $offer['store']; ?></td>
                <td><?php echo $offer['availability']; ?></td>
                <td><?php echo $offer['category']; ?></td>
                <td><?php echo isset($offer['end_date']) ? $offer['end_date'] . ' ' . $offer['end_time'] : 'Sin fecha'; ?></td>
                <td>
                <?php
                if (isset($offer['end_time']) && $offer['end_time'] != '') {
                  $now = new DateTime();
                  $end = new DateTime($offer['end_date'] . ' ' . $offer['end_time']);

                  if ($end < $now) {
                    echo '<span class="badge text-bg-danger rounded-pill">Inactivo</span>';
                  } else {
                    echo '<span class="badge text-bg-success rounded-pill">Activo</span>';
                  }
                } else {
                  echo '<span class="badge text-bg-success rounded-pill">Activo</span>';
                }
                ?>
                </td>
                <td>
                  <div class="d-flex flex-row">
                    <a href="offer.php?id=<?php echo $offer['offer_id']; ?>" class='btn btn-info btn-sm mx-1' data-bs-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                    <a href='share.php?id=<?php echo $offer['offer_id']; ?>' class='btn btn-warning btn-sm mx-1' data-bs-toggle="tooltip" title="Editar"><i class="bi bi-pencil"></i></a>
                    <a href='#' class='btn btn-danger btn-sm btn-delete mx-1' data-bs-toggle="tooltip" title="Eliminar"><i class="bi bi-trash3"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  on_load = () => {
    new DataTable('#my_offers_table', {responsive: true});

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function respuesta(ajax) {
      // var html = ajax.responseText;
      console.log('Se borro');
    }

    $('.btn-delete').on('click', function(event) {
      event.preventDefault();
      var row = $(this).closest('tr');
      $id = row[0].getAttribute('key');
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
              row.remove();
              
              var ajax = new XMLHttpRequest();
              ajax.onreadystatechange = () => {
                if (ajax.readyState == 4 && ajax.status == 200) {
                  console.log('Se borro');
                  Swal.fire(
                    'Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                  );
                }
              }
              ajax.open('POST', '/offers/actions/delete_offer.php', true);
              ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
              ajax.send('id=' + encodeURIComponent($id));
          }
      });
    });
  };
</script>

<?php include '../shared/footer.php'; ?>
