<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['user_id']))) {
  header('Location: ../auth/login.php');
  exit;
}

include_once '../utils.php';
include_once '../config.php';
include_once '../Database.php';

$user = array();

try {
  $database = new Database();
  $db = $database->getConnection();
  $res = $db->query("SELECT * FROM Users WHERE user_id = '" . $_SESSION['user_id'] . "' limit 1;");

  while ($registro = $res->fetch_row()) {
      $user['user_id'] = $registro[0];
      $user['user'] = $registro[1];
      $user['email'] = $registro[2];
      $user['avatar'] = $registro[4];
      $user['role'] = $registro[5];
  }
  $database->closeConnection();
} catch (mysqli_sql_exception $e) {
  header('Location: ../shared/errors/404.php');
  exit;
}
?>

<?php $title = "My cuenta | {$_SESSION['user']}"; ?>
<?php include '../shared/header.php'; ?>
<div class="container" height="400px">
  <div class="card mt-2" >
    <div class="card-body px-5 py-4">
      <div class="row">
        <div class="col-md-4 p-4">
            <div class="bg-body-tertiary d-flex justify-content-center align-items-center">
              <img id="user-avatar-image" class="img-fluid rounded-start" width="250px"  src='<?php echo $user['avatar'] == '' || $user['avatar'] == null ? '/assets/images/user.png' : $user['avatar']  ?>'>
            </div>
            <div class="mt-3 d-grid">
              <button id="change-avatar-btn" class="btn btn-outline-primary" onclick="changeAvatar(event)" >Cambiar avatar</button>
              <input type="file" id="image-file-input" name="image" class="form-control" accept="image/png, image/jpeg" hidden onchange="onChangeImageInput(this)"/>
            </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12 text-center">
              <h1><span class="fw-bold"><?php echo $user['user']; ?></span> <span class="badge text-bg-primary fs-6">Admin</span></h1>
            </div>
          </div>
          <div class="row">
            <hr class="mt-2"/>
            <div class="col-md-12">
              <p class="fs-5"><span class="fw-semibold">Email:</span> <span><?php echo $user['email'];?></span></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12 d-flex flex-column align-items-end gap-3">
            <button id="return-btn" class=" btn btn-dark btn-lg" data-toggle="tooltip" data-placement="left" title="Regresar">Regresar <i class="bi bi-arrow-return-left"></i></button>
          </div>
      </div>
    </div>
  </div>
</div>
<script>
  function changeAvatar(event) {
      event.preventDefault();
      document.getElementById('change-avatar-btn').hidden = true;
      document.getElementById('image-file-input').hidden = false;
  }

  function onChangeImageInput2(event) {
    document.getElementById('change-avatar-btn').hidden = false;
    document.getElementById('image-file-input').hidden = true;
  }

  function onChangeImageInput(input) {
            if (input.files && input.files[0]) {
                var formData = new FormData();
                formData.append('image', input.files[0]);

                $.ajax({
                    url: '/users/ajax/upload_image.php', // Cambia esta URL a la ruta correcta en tu servidor
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                      response = JSON.parse(response);
                      document.getElementById('user-avatar-image').src = response.url;
                        document.getElementById('change-avatar-btn').hidden = false;
                        document.getElementById('image-file-input').hidden = true;

                        document.getElementById('navbar-user-avatar').src =response.url;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        }

  
  on_load = () => {
    $('#return-btn').on('click', function(event) {
        if (window.history.length > 2) {
          window.history.go(-1);
        } else {
          window.location.replace("../index.php");
        }
      });
  }
</script>

<?php include '../shared/footer.php'; ?>