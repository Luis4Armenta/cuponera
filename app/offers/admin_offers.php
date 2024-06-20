<?php
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../auth/login.php');
  exit;
}
?>

<?php $title = 'Administrar promociones'; ?>
<?php include '../shared/header.php'; ?>

<div class="container">
  <div class="card mt-2 px-4">
    <div class="card-body">
      <div class="row text-center">
        <h1>Administrar promociones</h1>
      </div>
      <div class="row">

        <table class="table table-striped" id="admin_offers_table" style="width:100%">
          <thead class="table-light">
            <tr>
              <th scope="col" class="text-center">Titulo</th>
              <th scope="col" class="text-center">Tienda</th>
              <th scope="col" class="text-center">Disponibilidad</th>
              <th scope="col" class="text-center">Categoria</th>
              <th scope="col" class="text-center">Expira</th>
              <th scope="col" class="text-center">Estado</th>
              <th scope="col" class="text-center">Usuario publicador</th>
              <th scope="col" class="text-center">Tiempo en plataforma</th>
              <th scope="col" class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr key="1">
              <td>Oferta 1</td>
              <td>Tienda 1</td>
              <td>Disponible</td>
              <td>Categoria 1</td>
              <td>2024-06-30 12:00</td>
              <td><span class="badge text-bg-success rounded-pill">Activo</span></td>
              <td>Dato 1.1</td>
              <td>Dato 1.2</td>
              <td>Dato 1.3</td>
              <td>
                <div class="d-flex flex-row">
                  <a href="offer.php?id=1" class='btn btn-info btn-sm mx-1' data-bs-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                  <a href='#' class='btn btn-danger btn-sm btn-delete mx-1' data-bs-toggle="tooltip" title="Eliminar"><i class="bi bi-trash3"></i></a>
                </div>
              </td>
            </tr>
            <tr key="2">
              <td>Oferta 2</td>
              <td>Tienda 2</td>
              <td>No Disponible</td>
              <td>Categoria 2</td>
              <td>2024-07-15 18:00</td>
              <td><span class="badge text-bg-danger rounded-pill">Inactivo</span></td>
              <td>Dato 2.1</td>
              <td>Dato 2.2</td>
              <td>Dato 2.3</td>
              <td>
                <div class="d-flex flex-row">
                  <a href="offer.php?id=2" class='btn btn-info btn-sm mx-1' data-bs-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                  <a href='#' class='btn btn-danger btn-sm btn-delete mx-1' data-bs-toggle="tooltip" title="Eliminar"><i class="bi bi-trash3"></i></a>
                </div>
              </td>
            </tr>
            <!-- Agrega más filas según sea necesario -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  on_load = () => {
    new DataTable('#admin_offers_table', {responsive: true});

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function respuesta(ajax) {
      console.log('Se borro');
    }

    $('.btn-delete').on('click', function(event) {
      event.preventDefault();
      var row = $(this).closest('tr');
      var id = row[0].getAttribute('key');
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
              // Simula una llamada AJAX exitosa
              console.log('Se borro');
              Swal.fire(
                'Eliminado!',
                'El registro ha sido eliminado.',
                'success'
              );
          }
      });
    });
  };
</script>

<?php include '../shared/footer.php'; ?>
