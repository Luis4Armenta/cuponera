<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    

    <title><?php echo isset($title) ? $title : 'Titulo'; ?></title>
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
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">Cuponera</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex ms-auto" action="search.php" method="GET">
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
                <input class="form-control me-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar" aria-describedby="addon-wrapping">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>

              </div>
            </form>
            <ul class="navbar-nav">
              <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item dropdown mx-4">
                  <a  class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/user.png" class="rounded-circle" height="33" alt="Avatar" loading="lazy"/>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="" href="#"><h6 class="dropdown-header text-center" ><?php echo $_SESSION['user']; ?></h6></li>
                    <li><div class="dropdown-divider"></li>

                    <li class="dropdown-item">
                      <a href="account.php?user=<?php echo urlencode($_SESSION['user']); ?>" class="text-decoration-none text-black">
                        Mi cuenta
                      </a>
                    </li>
                    
                    <li class="dropdown-item" >
                      <a href="my_saved_promotions.php" class="text-decoration-none text-black">
                        Guardados para más tarde
                      </a>  
                    </li>
                    <li class="dropdown-item" >
                      <a href="my_promotions.php" class="text-decoration-none text-black">
                        Ofertas publicadas
                      </a>  
                    </li>
                    <li><div class="dropdown-divider"></li>
                    <li class="dropdown-item">
                      <a  href="logout.php" class="text-decoration-none">
                        Cerrar sesión
                      </a>
                    </li>
                  </ul>
                </li>
              <?php else: ?>
                <li class="nav-item mx-4">
                  <a class="btn btn-primary" href="login.php">Registrarse / Iniciar sesión</a>
                </li>
              <?php endif; ?>
              <li class="nav-item mx-4">
                <a class="btn btn-success" href="<?php echo isset($_SESSION['user']) ? 'share.php' : 'login.php'; ?>"><i class="bi bi-plus p-0 m-0 fw-bold"></i>  Compartir</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
