<?php

    require 'models/article.class.php';

    class ArticleController{

        // Ajoute un article
        public function addArticle($id_article, $designation, $prix, $categorie){

            try{
                $articles = new Article();
                $articles->insertArticle($id_article, $designation, $prix, $categorie);
            }catch(Exception $e){
                echo "Erreur, impossible d'ajouter un article : " . $e->getMessage();
            }

        }

        // Récupère les infos d'un article avec son ID
        public function articleById($id_article){

            try{
                $articles = new Article();
                return $articles->getArticleById($id_article);
            }catch(Exception $e){
                echo "Erreur : " . $e->getMessage();
            }

        }

        // Modifie un article
        public function modifier($id_article, $designation, $prix, $categorie){

            try{
                $articles = new Article();
                $articles->updateArticle($id_article, $designation, $prix, $categorie);
                header('Location: index.php?action=nonCommander');
            }catch(Exception $e){
                echo "Erreur, impossible de modifier l'article : " . $e->getMessage();
            }

        }

        // Liste des catégories article
        public function listeCategorie(){

            try{
                $articles = new Article();
                return $articles->categorie();
                require 'views/add.php';
            }catch(Exception $e){
                echo "Erreur : " . $e->getMessage();
            }

        }

        // Supprime un article avec son ID
        public function suppArticle($id_article){

            try{
                $articles = new Article();
                $articles->deleteArticle($id_article);
                header("Location: index.php?action=nonCommander");
                exit();
            }catch(Exception $e){
                echo "Erreur, impossible de supprimer l'article : " . $e->getMessage();
            }

        }

        // Liste des articles commander
        public function listeCommandes(){

            try{
                $articles = new Article;
                $commandes = $articles->commandes();
                require 'views/commande.php';
            }catch(Exception $e){
                echo "Erreur, impossible d'obtenir la liste des commandes : " . $e->getMessage();
            }

        }

        // Récupère les données client et de leur commande pour générer un PDF
        public function facture(){

            try{
                $articles = new Article();
                require 'views/facture.php';
            }catch(Exception $e){
                echo "Erreur, impossible de générer le fichier PDF : " . $e->getMessage();
            }

        }

        // Génére un graphique avec les ventes total par catégorie
        public function afficherGraphiqueVentes() {
            
            try{
                // Inclure les bibliothèques JpGraph
                require_once 'library/jpgraph/src/jpgraph.php';
                require_once 'library/jpgraph/src/jpgraph_bar.php';
                
                $articles = new Article();
                
                // Récupérer les données des volumes de ventes par catégorie
                $data = $articles->getVolumesParCategorie();
                
                // Extraire les catégories et les volumes dans des tableaux séparés
                $categories = [];
                $volumes = [];
                
                foreach ($data as $row) {
                    $categories[] = $row['categorie'];
                    $volumes[] = $row['total'];
                }
                
                // Créer le graphique en barres
                $graph = new Graph(1250, 600);
                $graph->SetScale('textlin');
                $graph->img->SetMargin(75,30,40,50);
                
                // Ajouter les labels des catégories
                $graph->xaxis->SetTickLabels($categories);
                $graph->xaxis->title->Set("Catégories");
                $graph->yaxis->title->Set("Volume de Ventes");

                // Décaler le titre de l'axe Y vers la gauche
                $graph->yaxis->SetTitleMargin(50);
                
                // Ajouter un titre
                $graph->title->Set("Volume de Ventes par Catégorie");
                
                // Créer un histogramme avec les volumes
                $barplot = new BarPlot($volumes);
                
                // Ajouter le graphique au graphe
                $graph->Add($barplot);
                
                // Afficher les valeurs au-dessus des barres
                $barplot->value->Show();
                $barplot->value->SetFormat('%d');
                $barplot->value->SetFont(FF_ARIAL, FS_BOLD, 11);
                // Changer la couleur du texte au-dessus des barres
                $barplot->value->SetColor("black");
                // Définir les couleurs des barres
                $barplot->SetFillColor(array('#FF0000', '#1ce447', '#2f00ff', 'black', '#e79315'));
                
                // Afficher uniquement l'image du graphique
                $graph->Stroke();
            }catch(Exception $e){
                echo "Erreur, impossible d'afficher le graphique : " . $e->getMessage();
            }
        }

        public function getGainTotalAjax() {
            $articles = new Article();
            if (isset($_GET['categorie'])) {
                $categorie = $_GET['categorie'];
                try {
                    $gainTotal = $articles->getGainTotalParCategorie($categorie);
                    echo json_encode(['gain_total' => $gainTotal]);
                } catch (Exception $e) {
                    // Retourner une réponse JSON en cas d'erreur
                    echo json_encode(['error' => 'Erreur lors de la récupération du gain total']);
                }
            } else {
                // Gérer le cas où le paramètre "categorie" est manquant
                echo json_encode(['error' => 'Paramètre catégorie manquant']);
            }
        }

        public function commandeAjax(){
            try {
                $articles = new Article();
                $records = $articles->commandes();
            
                header('Content-Type: application/json');
                echo json_encode($records);
            } catch (Exception $e) {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        public function commanderAjax(){
            try {
                $articles = new Article();
                $records = $articles->getArticles();
            
                header('Content-Type: application/json');
                echo json_encode($records);
            } catch (Exception $e) {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        public function nonCommanderAjax(){
            try {
                $articles = new Article();
                $records = $articles->getArticlesNonCommander();
            
                header('Content-Type: application/json');
                echo json_encode($records);
            } catch (Exception $e) {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

    }