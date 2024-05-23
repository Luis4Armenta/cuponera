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
      <nav>
        <ul>
          <li><a>Hola</a></li>
          <li><a>Hola</a></li>
        </ul>
      </nav>
    </header>