<?php
session_start();
if(isset($_SESSION['user'])){
  Header('Location: ../index.php');
  exit;
}
?>

<?php
$title = 'Registro';
include '../shared/header.php';
?>
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title text-center mb-4  lead-with-shadow">Nuevo Usuario</h1>
          <form method="POST" action="/auth/actions/create_user.php">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="user">Usuario</label>
              <input type="text" id="user" name="user" class="form-control" required minlength="4" maxlength="20">
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" required minlength="8" maxlength="16">
              <div class="invalid-feedback">
                Ingrese una contraseña válida (debe ser de 8 a 16 caracteres).
              </div>
            </div>
            <p>Si ya tienes una cuenta puede ingresar <a href="/auth/login.php">aquí</a></p>
            <div class="d-grid">
              <button id="submitBtn" type="submit" class="btn btn-primary btn-lg">Registrarse</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  on_load = () => {
    // Expresión regular para validar el formato de email
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Función para validar el email
    function validateEmail() {
        var email = $('#email').val();
        if (email !== '' && isValidEmail(email)) {
            $('#email').removeClass('is-invalid').addClass('is-valid');
            validateSubmitButton();
        } else {
            $('#email').removeClass('is-valid').addClass('is-invalid');
            validateSubmitButton();
        }
    }

    // Función para validar el usuario
    function isValidUser(user) {
        var userRegex = /^[a-zA-Z0-9_-]{4,20}$/;
        return userRegex.test(user);
    }

    function validateUser() {
        var user = $('#user').val();
        if (user !== '' && isValidUser(user)) {
            $('#user').removeClass('is-invalid').addClass('is-valid');
            validateSubmitButton();
        } else {
            $('#user').removeClass('is-valid').addClass('is-invalid');
            validateSubmitButton();
        }
    }

    // Función para validar la contraseña
    function isValidPassword(password) {
        var passwordRegex = /^[\w-]{8,16}$/;
        return passwordRegex.test(password);
    }

    function validatePassword() {
        var password = $('#password').val();
        if (password !== '' && isValidPassword(password)) {
            $('#password').removeClass('is-invalid').addClass('is-valid');
            validateSubmitButton();
        } else {
            $('#password').removeClass('is-valid').addClass('is-invalid');
            validateSubmitButton();
        }
    }

    // Función para habilitar o deshabilitar el botón de submit
    function validateSubmitButton() {
        var isValidEmailField = $('#email').hasClass('is-valid');
        var isValidUserField = $('#user').hasClass('is-valid');
        var isValidPasswordField = $('#password').hasClass('is-valid');

        if (isValidEmailField && isValidUserField && isValidPasswordField) {
            $('#submitBtn').prop('disabled', false);
        } else {
            $('#submitBtn').prop('disabled', true);
        }
    }

    // Eventos para validar en tiempo real
    $('#email').on('keyup', function () {
        validateEmail();
    });

    $('#user').on('keyup', function () {
        validateUser();
    });

    $('#password').on('keyup', function () {
        validatePassword();
    });
  }
</script>

<?php include '../shared/footer.php'; ?>
