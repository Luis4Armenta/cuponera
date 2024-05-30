<?php
session_start();

if (isset($_SESSION['user'])) {
  header('Location: welcome.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error de Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8d7da;
      font-family: 'Averta CY', 'Helvetica Neue', 'Helvetica', 'Arial', 'Lucida Grande', 'sans-serif';
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .error-container {
      background-color: #ffffff;
      border: 1px solid #f5c6cb;
      border-radius: 10px;
      padding: 30px;
      max-width: 400px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .error-icon {
      font-size: 4em;
      color: #f5c6cb;
      margin-bottom: 20px;
    }
    .lead-with-shadow {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
  </style>
</head>
<body>
  <div class="error-container">
    <div class="error-icon">⚠️</div>
    <h1 class="display-4">Usuario o contraseña inválidos</h1>
    <p class="lead lead-with-shadow">Por favor, verifica tus credenciales e intenta de nuevo.</p>
    <a href="login.php" class="btn btn-primary focus">Regresar</a>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
