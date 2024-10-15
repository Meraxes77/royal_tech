<?php

require_once 'vendor/autoload.php';

ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoloader pour charger automatiquement les classes de contrôleurs, modèles, etc.
spl_autoload_register(function ($class) {
    $directories = [
        'controllers/',   // Chemin vers les contrôleurs
        'models/',        // Chemin vers les modèles (si nécessaire)
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Gestion des actions
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Création des instances de contrôleurs
$userController = new UserController();
$articleController = new ArticleController();
$factureController = new FactureController();
$excelController = new ExcelController();

// Vérification si l'utilisateur doit être authentifié pour certaines actions
if (!in_array($action, ['login', 'register'])) {
    $userController->isAuthenticated(); // Vérifie la connexion pour les actions autres que login et register
}

// Switch pour gérer les différentes actions
switch ($action) {
    case 'login':
        $userController->loginPage();
        break;
    case 'logout':
        $userController->logout();
        exit();
    case 'commander':
        require 'views/listeArticleCommander.php';
        break;
    case 'nonCommander':
        require 'views/listeArticleNonCommander.php';
        break;
    case 'ajout':
        $categorie = $articleController->listeCategorie();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleController->addArticle($_POST['id_article'], $_POST['designation'], $_POST['prix'], $_POST['categorie']);
            header("Location: index.php?action=ajout");
            exit();
        }
        require 'views/add.php';
        break;
    case 'modifier':

        if(isset($_GET['id'])){

            $article = $articleController->articleById($_GET['id']);
            $categorie = $articleController->listeCategorie();

            if(isset($_POST['id_article'])){
                $articleController->modifier($_POST['id_article'], $_POST['designation'], $_POST['prix'], $_POST['categorie']);

            }

        }       
        
        require 'views/modifier.php';
        break;
    case 'supp':
        $articleController->suppArticle($_GET['id']);
        break;
    case 'commandes':
        $articleController->listeCommandes();
        break;
    case 'facture':
        if (isset($_GET['id'])) {
            $factureController->afficherFacture($_GET['id']);
        } else {
            header("Location: index.php?action=commandes");
        }
        break;
    case 'graphVentes':
        $articleController->afficherGraphiqueVentes();
        break;
    case 'afficherGraphiqueDansPage':
        include('views/graph.php');
        break;
    case 'listeExcel':
        $excelController->getListFileExcel();
        break;
    case 'afficherExcel':
        $excelController->afficherExcel();
        break;
    case 'getExcel':
        $excelController->majArticles();
        break;
    case 'getGainTotalAjax':
        $articleController->getGainTotalAjax();
        break;
    case 'commandeAjax':
        $articleController->commandeAjax();
        break;
    case 'commanderAjax':
        $articleController->commanderAjax();
        break;
    case 'nonCommanderAjax':
        $articleController->nonCommanderAjax();
        break;
    default:
        header("Location: index.php?action=login");
        break;
}

ob_end_flush();