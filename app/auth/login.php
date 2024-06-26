<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: ../index.php');
  exit;
}
?>

<?php
$title = 'Login';
include '../shared/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">
                <div class="card-header text-center">
                    <h1 class="fs-1">Login</h1>
                </div>
                <div class="card-body">
                    <form id="loginForm" method="POST" action="actions/auth.php">
                        <div class="form-group">
                            <label for="user">Usuario</label>
                            <input type="text" class="form-control" id="user" name="user" required minlength="4" maxlength="20" placeholder="usuario"/>
                            <div class="invalid-feedback">
                                Ingrese un usuario válido (entre 4 y 20 caracteres).
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="16" placeholder="contraseña"/>
                            <div class="invalid-feedback">
                                Ingrese una contraseña válida (Deberá ser de 8 caracteres).
                            </div>
                        </div>
                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="recordarme" name="recordarme"/>
                            <label class="form-check-label" for="recordarme">Recordarme</label>
                        </div>
                        <p class="mt-3">No tengo una cuenta, quiero <a href="./signin.php">registrarme</a></p>
                        <div class="d-grid">
                            <input type="submit" value="Ingresar" class="btn btn-primary"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../shared/footer.php'; ?>

<script>
    // Validaciones de formulario con Bootstrap y JavaScript
    (function() {
        'use strict';

        // Seleccionar el formulario y los campos de entrada
        const form = document.getElementById('loginForm');
        const inputs = form.querySelectorAll('input');

        const regexValidations = {
            user: /^[a-zA-Z0-9_-]{4,20}$/,
            password: /^[\w-]{8,16}$/
        };

        // Función para validar los campos
        function validateInputs() {
            let isValid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && input.value.trim() === '') {
                    isValid = false;
                }

                // Validaciones específicas por tipo de campo al tocar o modificar
                if (input.id === 'user' || input.id === 'password') {
                    input.addEventListener('input', function() {
                        if (input.value.trim() === '') {
                            input.classList.remove('is-valid');
                            input.classList.add('is-invalid');
                        } else {
                            if ((input.id === 'user' && !regexValidations.user.test(input.value.trim())) ||
                                (input.id === 'password' && !regexValidations.password.test(input.value.trim()))) {
                                input.classList.remove('is-valid');
                                input.classList.add('is-invalid');
                            } else {
                                input.classList.remove('is-invalid');
                                input.classList.add('is-valid');
                            }
                        }

                        // Validar todo el formulario después de tocar o modificar un campo
                        validateForm();
                    });
                }
            });

            // Validar todo el formulario inicialmente
            validateForm();
        }

        // Función para validar todo el formulario
        function validateForm() {
            let isValidForm = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required') && input.value.trim() === '') {
                    isValidForm = false;
                } else {
                    if ((input.id === 'user' && !regexValidations.user.test(input.value.trim())) ||
                        (input.id === 'password' && !regexValidations.password.test(input.value.trim()))) {
                        isValidForm = false;
                    }
                }
            });

            // Aplicar estado de formulario válido o inválido al botón de enviar
            const submitButton = form.querySelector('input[type="submit"]');
            if (isValidForm) {
                submitButton.removeAttribute('disabled');
            } else {
                submitButton.setAttribute('disabled', 'disabled');
            }
        }

        // Validar los campos al inicio
        validateInputs();
    })();
</script>
