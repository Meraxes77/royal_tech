<?php

    $hidden = isset($_GET['action']) ? $_GET['action'] : '';
    $title2 = ' - RoyalTech';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo_societe.png">
    <title><?=$title . $title2 ?></title>
</head>
<body class="d-flex flex-column m-0 vh-100">

    <div class="d-flex">
        <aside class="<?php echo ($hidden == '') ? 'd-none' : '';echo ($hidden == 'login') ? 'd-none' : ''; echo ($hidden == 'register') ? 'd-none' : ''; ?>">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" id="sidebar">
                <div class="d-flex justify-content-center">
                    <img src="img/logo_societe.png" alt="" class="w-50">
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a id="commander" href="index.php?action=commander" class="nav-link text-white <?php echo ($hidden == 'commander') ? 'active' : ''; ?>" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4 me-2" viewBox="0 0 16 16"><path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/></svg>
                            Articles commandés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="nonCommander" href="index.php?action=nonCommander" class="nav-link text-white <?php echo ($hidden == 'nonCommander') ? 'active' : ''; ?>" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-x me-2" viewBox="0 0 16 16"><path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793z"/><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                            Articles non commandés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=ajout" class="nav-link text-white <?php echo ($hidden == 'ajout') ? 'active' : ''; echo ($_SESSION['role'] == 'Lecteur') ? 'd-none' : ''; ?>" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus me-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5"/><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/></svg>
                            Ajouter article
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=commandes" class="nav-link text-white <?php echo ($hidden == 'commandes') ? 'active' : ''; echo ($_SESSION['role'] == 'Lecteur') ? 'd-none' : ''; ?>" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-check me-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/></svg>
                            Liste des commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=listeExcel" class="nav-link text-white <?php echo ($hidden == 'listeExcel') ? 'active' : ''; echo ($_SESSION['role'] == 'Lecteur') ? 'd-none' : ''; ?>" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table me-2" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z"/></svg>
                            Liste des fichiers Excel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=afficherGraphiqueDansPage" class="nav-link text-white <?php echo ($hidden == 'afficherGraphiqueDansPage') ? 'active' : ''; ?>" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-data me-2" viewBox="0 0 16 16"><path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z"/><path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/><path d="M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0V9a1 1 0 0 0-1-1"/></svg>
                            Volume des ventes
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong><?php echo $_SESSION['login'] . ' - ' . $_SESSION['role'] ?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <!-- <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li> -->
                        <li><a class="dropdown-item" href="index.php?action=logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <div class="d-block" id="content">
            <?=$content ?>
        </div>

    </div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
    <script src="js/datatable.js"></script>
    <script src="js/validation.js"></script>
    <script src="js/script.js"></script>

</body>
</html>