<!-- header.php -->
<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title: 'Titulo'; ?></title>
    <link rel="stylesheet" href="assets/styles/main.css">
    <script src="https://kit.fontawesome.com/6b47139783.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php 
    if (isset($extra_styles) && count($extra_styles) > 0) {
      for ($i = 0; $i < count($extra_styles); $i++) {
        echo '<link rel="stylesheet" href="' . $extra_styles[$i] . '">';
      }
    }
    ?>
  </head>
  <body>
    <header>
      <nav class="navbar">
        <div class="navbar-left">
          <div class="navbar-brand">
            <a href="#">CUPONERA</a>
          </div>
        </div>
        <div class="navbar-right">
          <form class="search-form">
            <input type="text" placeholder="Buscar..." />
          </form>
          <?php if (isset($_SESSION['user'])): ?>
            <a href="#" >
              <button class="user-avatar"><img src="assets/images/user.png"/></button>
            </a>
          <?php else: ?>
            <a href="login.php">
              <button class="btn btn-rounded" id="btn-login">Registrarse / Iniciar sesión</button>
            </a>
          <?php endif; ?>
          <a href="#">
            <button class="btn btn-rounded" id="btn-share"><i class="fa-solid fa-plus"></i>Compartir</button>
          </a>
        </div>
      </nav>
    </header>