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
              <div class="valid-feedback">
                ¡Nunca había vito un email tan original!
              </div>
              <div class="invalid-feedback" id="email-invalid">
                Ese email no me parece muy convincente...
              </div>
            </div>
            <div class="form-group">
              <label for="user">Usuario</label>
              <input type="text" id="user" name="user" class="form-control" required minlength="4" maxlength="20">
              <div class="valid-feedback">
                ¡Ese usuario está perfecto!
              </div>
              <div class="invalid-feedback" id="user-invalid">
                Los usuarios solo pueden contener letras, números, guiones y guiones bajos.
              </div>
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" required minlength="8" maxlength="16">
              <div class="invalid-feedback">
                Ingrese una contraseña válida (debe ser de 8 a 16 caracteres).
              </div>
              <div class="valid-feedback">
                ¡Con eso será suficiente!
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
    var success_form = false;
    var invalid_email = document.getElementById('email-invalid');
    var invalid_user = document.getElementById('user-invalid');

    // Expresión regular para validar el formato de email
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Función para validar el email
    function validateEmail() {
        var email = $('#email').val();
        if (email !== '' && isValidEmail(email)) {
          console.log('siempre')
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
                        if (invalid_email) {
                          invalid_email.innerText = 'Ese email parece no estar disponible.';
                        }
                    }
                    validateSubmitButton();
                }
            });
            validateSubmitButton();
        } else {
            if (invalid_email) {
              invalid_email.innerText = 'Ese email no me parece muy convincente...';
            }
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
                        if (invalid_user) {
                          invalid_user.innerText = 'Ese usuario parece no estar disponible.';
                        }
                    }
                    validateSubmitButton();
                }
            });
            validateSubmitButton();
        } else {
            $('#user').removeClass('is-valid').addClass('is-invalid');
            if (invalid_user) {
              invalid_user.innerText = 'Los usuarios solo pueden contener letras, números, guiones y guiones bajos.';
            }
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
