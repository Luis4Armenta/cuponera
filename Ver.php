<?php include 'shared/header.php'; ?>
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
    <script>
        on_load = () =>  {
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
        };
    </script>
<?php include 'shared/footer.php'; ?>
