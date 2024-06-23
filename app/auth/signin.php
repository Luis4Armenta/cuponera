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
              <input type="text" id="user" name="user" class="form-control" required minlength="4" maxlength="20" >
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" required minlength="8" maxlength="16">
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
            $.ajax({
                url: '/auth/ajax/check_email.php',
                method: 'POST',
                data: { email: email },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.emailAvailable) {
                        $('#email').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $('#email').removeClass('is-valid').addClass('is-invalid');
                    }
                    validateSubmitButton();
                }
            });
        } else {
            $('#email').removeClass('is-valid is-invalid').addClass('is-invalid');
            validateSubmitButton();
        }
    }

    function isValidUser(user) {
        var userRegex = /^[a-zA-Z0-9_-]{4,20}$/;
        return userRegex.test(user);
    }

    // Función para validar el usuario
    function validateUser() {
        var user = $('#user').val();
        if (user !== '' && isValidUser(user)) {
            $.ajax({
                url: '/auth/ajax/check_user.php',
                method: 'POST',
                data: { user: user },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.userAvailable) {
                        $('#user').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $('#user').removeClass('is-valid').addClass('is-invalid');
                    }
                    validateSubmitButton();
                }
            });
        } else {
            $('#user').removeClass('is-valid is-invalid').addClass('is-invalid');
            validateSubmitButton();
        }
    }

    // Función para habilitar o deshabilitar el botón de submit
    function validateSubmitButton() {
        if ($('#email').hasClass('is-valid') && $('#user').hasClass('is-valid')) {
            $('#submitBtn').prop('disabled', false);
        } else {
            $('#submitBtn').prop('disabled', true);
        }
    }

    // Eventos para validar el email y el usuario en tiempo real
    $('#email').on('keyup', function () {
        validateEmail();
    });

    $('#user').on('keyup', function () {
        validateUser();
    });
  }
</script>

<?php include '../shared/footer.php'; ?>