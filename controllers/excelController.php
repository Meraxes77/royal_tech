<?php

require_once 'vendor/autoload.php';
require_once 'models/article.class.php';
require_once 'database/database.php';

use App\Entity\Ligne;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController {

    public $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection(); // Connexion à la base de données
    }

    // Liste les fichiers Excel dans le dossier "filesXls"
    public function getListFileExcel() {
        try{
            $directory = 'fileXLS/'; // Dossier contenant les fichiers Excel
            $files = scandir($directory);

            if ($files === false) {
                throw new Exception("Impossible de lire le répertoire.");
            }

            // Filtrer les fichiers pour ne garder que les fichiers .xlsx
            $excelFiles = [];
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
                    $excelFiles[] = $file;
                }
            }

            // Passer les fichiers à la vue
            require 'views/listeExcel.php';
        }catch(Exception $e){
            echo "Erreur, impossible d'obtenir la liste des fichiers excel : " . $e->getMessage();
        }
    }

    // Montre le fichier Excel choisie dans la liste
    public function afficherExcel() {
        try{
            if (isset($_GET['nomFichier'])) {
                $nomFichier = $_GET['nomFichier'];
                $cheminFichier = 'fileXLS/' . $nomFichier;
    
                if (file_exists($cheminFichier)) {
                    // Charger le fichier Excel avec PhpSpreadsheet
                    $spreadsheet = IOFactory::load($cheminFichier);
                    $sheet = $spreadsheet->getActiveSheet();
                    $donnees = $sheet->toArray();
    
                    $articles = [];
                    foreach ($donnees as $ligne) {
                        if ($ligne > 0) {  // Ignore la première ligne
                            $id_article = isset($ligne[0]) ? $ligne[0] : null;
                            $designation = isset($ligne[1]) ? $ligne[1] : null;
                            $prix = isset($ligne[2]) ? $ligne[2] : null;
                            $categorie = isset($ligne[3]) ? $ligne[3] : null;
        
                            $articles[] = new Article($id_article, $designation, $prix, $categorie);
                        }
                    }    
    
                    // Nombre de lignes dans le fichier Excel, -1 pour ne pas prendre en compte l'en-tête
                    $nombreDeLignes = count($donnees) - 1;
    
                    // Passer les données à la vue
                    require_once 'views/excel.php';
                } else {
                    throw new Exception("Le fichier n'existe pas.");
                }
            } else {
                throw new Exception("Aucun fichier sélectionné.");
            }
        }catch(Exception $e){
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Met à jours la bdd en fonction de la colonne action du fichier Excel
    public function majArticles() {
        try{
            $directory = 'fileXLS/'; // Répertoire  fichiers excel
            $archiveDirectory = 'fileXLS_archives/'; // Répertoire archiver fichiers excel
            $articleModel = new Article();
    
            if (isset($_GET['nomFichier'])) {
                $nomFichier = $_GET['nomFichier'];
    
                $cheminFichier = $directory . $nomFichier; // Chemin dossier excel
                $cheminArchive = $archiveDirectory . $nomFichier; // Chemin archive
    
                if (file_exists($cheminFichier)) {
                    // Charger le fichier Excel avec PhpSpreadsheet
                    $spreadsheet = IOFactory::load($cheminFichier);
                    $sheet = $spreadsheet->getActiveSheet();
                    $donnees = $sheet->toArray();
    
                    foreach ($donnees as $ligne) {
                        if ($ligne > 0) {  // Ignorer la première ligne (en-tête)
                            $id_article = isset($ligne[0]) ? $ligne[0] : null;
                            $designation = isset($ligne[1]) ? $ligne[1] : null;
                            $prix = isset($ligne[2]) ? $ligne[2] : null;
                            $categorie = isset($ligne[3]) ? $ligne[3] : null;
                            $action = strtolower(trim($ligne[4]));
    
                            // Exécuter les actions selon la colonne action
                            if ($action === 'insert') {
                                $articleModel->insertArticle($id_article, $designation, $prix, $categorie);
                            } elseif ($action === 'update' && $id_article !== null) {
                                $articleModel->updateArticle($id_article, $designation, $prix, $categorie);
                            } elseif ($action === 'delete' && $id_article !== null) {
                                $articleModel->deleteArticle($id_article);
                            }
                        }
                    }
    
                    // Déplacer le fichier vers le répertoire d'archive
                    if (rename($cheminFichier, $cheminArchive)) {
                        // Fichier déplacé avec succès
                    } else {
                        throw new Exception("Erreur lors du déplacement du fichier $nomFichier.<br>");
                    }
                } else {
                    throw new Exception("Le fichier n'existe pas.");
                }
            } else {
                throw new Exception("Aucun fichier sélectionné.");
            }
        }catch(Exception $e){
            echo "Erreur lors de modification de la bdd : " . $e->getMessage();
        }
    }

    
}