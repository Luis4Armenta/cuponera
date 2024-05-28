<!-- header.php -->
<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title: 'Titulo'; ?></title>
    <link rel="stylesheet" href="assets/styles/main.css">
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
            <button class="user-avatar"><img src="assets/images/user.png"/></button>
          <?php else: ?>
            <button class="btn btn-rounded" id="btn-login">Registrarse / Iniciar sesión</button>
          <?php endif; ?>
          <button class="btn btn-rounded" id="btn-share">Compartir</button>
        </div>
      </nav>
    </header>