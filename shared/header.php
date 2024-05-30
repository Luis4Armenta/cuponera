<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title: 'Titulo'; ?></title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/6b47139783.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Averta CY', 'Helvetica Neue', 'Helvetica', 'Arial', 'Lucida Grande', 'sans-serif';
            margin: 0;
            color: #333;
        }
        .navbar {
            background-color: #5a64e7 !important;
            padding: 10px 40px;
        }
        .navbar-brand a {
            color: #fff;
            text-decoration: none;
            font-size: 1.8em;
            font-weight: bold;
        }
        .search-form input[type="text"] {
            padding: 5px;
            font-size: 1em;
            border: none;
            border-radius: 20px;
            margin-right: 10px;
            height: 35px;
            width: 310px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        #btn-login, #btn-share {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #btn-login:hover, #btn-share:hover {
            background-color: #45a049;
        }
        .user-avatar {
            border: none;
            border-radius: 50%;
            overflow: hidden;
            padding: 0;
            width: 40px;
            height: 40px;
            margin-left: 10px;
            cursor: pointer;
        }
        .user-avatar img {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        .user-avatar img:hover {
            transform: scale(1.1);
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 10px;
            font-size: 1em;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .btn:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
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
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">¡BIENVENIDO!</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <form class="d-flex ms-auto my-2 my-lg-0 search-form">
                        <input class="form-control" type="search" placeholder="Buscar..." aria-label="Buscar">
                    </form>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <div class="user-avatar"><img src="assets/images/user.png" alt="User Avatar"></div>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-outline-light" id="btn-login" href="login.php">Registrarse / Iniciar sesión</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="btn btn-success" id="btn-share" href="#"><i class="fa-solid fa-plus"></i> Compartir</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Incluir jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
