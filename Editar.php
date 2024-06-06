<?php include 'shared/header.php'; ?>
    <div class="container">
        <h2 class="text-center mb-4">Editar Empleado</h2>
        <form id="editarEmpleadoForm">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="posicion" class="form-label">Posición:</label>
                <input type="text" class="form-control" id="posicion" name="posicion" required>
            </div>
            <div class="form-group">
                <label for="oficina" class="form-label">Oficina:</label>
                <input type="text" class="form-control" id="oficina" name="oficina" required>
            </div>
            <div class="form-group">
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" class="form-control" id="edad" name="edad" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="salario" class="form-label">Salario:</label>
                <input type="text" class="form-control" id="salario" name="salario" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary mr-2" id="guardar"><i class="fas fa-save mr-1"></i>Guardar</button>
                <button type="submit" class="btn btn-success mr-2" id="guardar_continuar"><i class="fas fa-save mr-1"></i>Guardar y Continuar</button>
                <button type="button" class="btn btn-danger" id="cancelar"><i class="fas fa-times mr-1"></i>Cancelar</button>
            </div>
        </form>
    </div>
<?php include 'shared/footer.php'; ?>
