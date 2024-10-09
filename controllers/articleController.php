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
                $graph = new Graph(1250, 750);
                $graph->SetScale('textlin');
                $graph->img->SetMargin(60,30,40,50);
                
                // Ajouter les labels des catégories
                $graph->xaxis->SetTickLabels($categories);
                $graph->xaxis->title->Set("Catégories");
                $graph->yaxis->title->Set("Volume de Ventes");
                
                // Ajouter un titre
                $graph->title->Set("Volume de Ventes par Catégorie");
                
                // Créer un histogramme avec les volumes
                $barplot = new BarPlot($volumes);
                
                // Afficher les valeurs au-dessus des barres
                $barplot->value->Show();
                $barplot->value->SetFormat('%d');
                $barplot->value->SetFont(FF_ARIAL, FS_NORMAL, 9);
                
                // Ajouter le graphique au graphe
                $graph->Add($barplot);
                
                // Afficher uniquement l'image du graphique
                $graph->Stroke();
            }catch(Exception $e){
                echo "Erreur, impossible d'afficher le graphique : " . $e->getMessage();
            }
        }

    }