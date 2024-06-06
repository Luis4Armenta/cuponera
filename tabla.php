<?php include 'shared/header.php'; ?>
<div class="container mt-5">
  <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title">Tabla de Empleados</h2>
            </div>
            <div class="card-body">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Posición</th>
                            <th>Oficina</th>
                            <th>Edad</th>
                            <th>Fecha de Inicio</th>
                            <th>Salario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-primary">
                            <td>Santiago SantaOlaya</td>
                            <td>Arquitecto</td>
                            <td>UPIICSA</td>
                            <td>22</td>
                            <td>2024/04/25</td>
                            <td>$320,800</td>
                            <td>
                                <a href='#' class='btn btn-info btn-sm' data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href='#' class='btn btn-warning btn-sm' data-toggle="tooltip" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href='#' class='btn btn-danger btn-sm btn-delete' data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr class="table-primary">
                            <td>George Garcia Gonzales</td>
                            <td>Contador</td>
                            <td>UPIICSA</td>
                            <td>22</td>
                            <td>2024/07/25</td>
                            <td>$170,750</td>
                            <td>
                                <a href='#' class='btn btn-info btn-sm' data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href='#' class='btn btn-warning btn-sm' data-toggle="tooltip" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href='#' class='btn btn-danger btn-sm btn-delete' data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr class="table-primary">
                            <td>Armenta Delgadillo</td>
                            <td>Contador</td>
                            <td>UPIICSA</td>
                            <td>22</td>
                            <td>2024/07/25</td>
                            <td>$170,750</td>
                            <td>
                                <a href='#' class='btn btn-info btn-sm' data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href='#' class='btn btn-warning btn-sm' data-toggle="tooltip" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href='#' class='btn btn-danger btn-sm btn-delete' data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <!-- Agrega más filas aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  <script>
    on_load = () => {
      let table = new DataTable('#example');
      // Inicializar tooltips
      $('[data-toggle="tooltip"]').tooltip();
      // modal eliminar
      $('.btn-delete').on('click', function(event) {
          event.preventDefault();
          var row = $(this).closest('tr');
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
                  Swal.fire(
                      'Eliminado!',
                      'El registro ha sido eliminado.',
                      'success'
                  )
              }
          });
      });
    }
    </script>
<?php include 'shared/footer.php'; ?>