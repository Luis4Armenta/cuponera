<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Empleado</title>
    <!-- Incluir CSS de Bootstrap y DataTables -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- Incluir CSS de FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Incluir CSS de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title">Detalles del Empleado</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Nombre:</strong></div>
                    <div class="col-sm-9">Santiago SantaOlaya</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Posición:</strong></div>
                    <div class="col-sm-9">Arquitecto</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Oficina:</strong></div>
                    <div class="col-sm-9">UPIICSA</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Edad:</strong></div>
                    <div class="col-sm-9">22</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Fecha de Inicio:</strong></div>
                    <div class="col-sm-9">2024/04/25</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Salario:</strong></div>
                    <div class="col-sm-9">$320,800</div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Regresar</a>
                    </div>
                    <div class="col-sm-3">
                        <a href="editar.php" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-danger" id="btn-delete"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir JS de Bootstrap y DataTables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <!-- Incluir JS de Bootstrap para tooltips -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Manejar el clic en el botón "Eliminar"
            $('#btn-delete').on('click', function(event) {
                event.preventDefault();
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
                        // Aquí puedes colocar la lógica para eliminar el registro
                        Swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        )
                    }
                });
            });
        });
    </script>
</body>
</html>

