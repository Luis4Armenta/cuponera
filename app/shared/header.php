<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title><?php echo isset($title) ? $title : 'Cuponera'; ?></title>
    <?php
    if (isset($extra_styles) && count($extra_styles) > 0) {
      for ($i = 0; $i < count($extra_styles); $i++) {
        echo '<link rel="stylesheet" href="' . $extra_styles[$i] . '">';
      }
    }
    ?>

  <script>
    var on_load = () => {
      return;
    }
  </script>
</head>
<body class="bg-body-secondary" onload="on_load()">
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-white border">
        <div class="container-fluid">
          <a class="navbar-brand mx-3" href="../index.php">Cuponera</a>
          <!-- Botón de hamburguesa solo en pantallas pequeñas -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Menú">
                <span class="navbar-toggler-icon"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 2): ?>
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="../offers/admin_offers.php">Administrar ofertas</a>
                </li>
              </ul>
            <?php endif; ?>
            <form class="d-flex ms-auto" action="/offers/search.php" method="GET">
              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="bi bi-search"></i></span>
                <input name="q" class="form-control me-sm-2" type="search" placeholder="Buscar..." aria-label="Buscar" aria-describedby="addon-wrapping">
                <button class="btn btn-outline-success" type="submit">Buscar</button>

              </div>
            </form>
            <ul class="navbar-nav mb-2 mb-lg-0">
              <?php if (isset($_SESSION['user'])): ?>
                <li class="nav-item dropdown mx-4">
                  <a  class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="navbar-user-avatar" src="<?php echo $_SESSION['avatar'] == null || $_SESSION['avatar'] == '' ? '../assets/images/user.png' : $_SESSION['avatar']; ?>" class="rounded-circle" height="33" alt="Avatar" loading="lazy"/>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="" href="#"><h6 class="dropdown-header text-center" ><?php echo $_SESSION['user']; ?></h6></li>
                    <li><div class="dropdown-divider"></li>

                    <li class="dropdown-item">
                      <a href="/users/my_account.php" class="btn btn-outline-success btn-sm w-100">
                        Mi cuenta
                      </a>
                    </li>
                    
                    <!-- <li class="dropdown-item" >
                      <a href="my_saved_promotions.php" class="text-decoration-none text-black">
                        Guardados para más tarde
                      </a>  
                    </li> -->
                    <li class="dropdown-item" >
                      <a href="/offers/my_offers.php" class=" btn btn-outline-success btn-sm w-100"> Mis ofertas publicadas</a>  
                    </li>
                    <li><div class="dropdown-divider"></li>
                    <li class="dropdown-item">
                      <a  href="../auth/actions/logout.php" class=" btn btn-outline-danger btn-sm w-100">
                        Cerrar sesión
                      </a>
                    </li>
                  </ul>
                </li>
              <?php else: ?>
                <li class="nav-item ms-4 me-1">
                  <a class="btn btn-primary" href="/auth/login.php">Registrarse / Iniciar sesión</a>
                </li>
              <?php endif; ?>
              <li class="nav-item ms-2 me-4 d-flex align-items-center">
                <a class="btn btn-success btn-lg py-1" href="<?php echo isset($_SESSION['user']) ? '/offers/share.php' : '/auth/login.php'; ?>"><i class="bi bi-plus p-0 m-0 fw-bold"></i>  Compartir</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    