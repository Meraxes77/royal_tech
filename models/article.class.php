<?php

require_once __DIR__ . '/../database/database.php';

class Article{

    private $conn;

    public $id_article;
    public $designation;
    public $prix;
    public $categorie;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Tableau des catégories
    public function categorie() {
        try {
            $sql = "SELECT categorie FROM `article` GROUP BY categorie";
            $categorie = array();
    
            foreach ($this->conn->query($sql) as $row) {
                $categorie[] = $row;
            }
    
            return $categorie;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des catégories : " . $e->getMessage();
        }
    }

    // Récuperer article avec son ID
    public function getArticleById($id_article) {
        try {
            $sql = "SELECT * FROM article WHERE id_article = :id_article";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_article', $id_article, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'article : " . $e->getMessage();
            return false;
        }
    }
    
    // Ajout d'article dans la bdd
    public function insertArticle($id_article, $designation, $prix, $categorie) {
        try {
            $sql = "INSERT INTO article (id_article, designation, prix, categorie) VALUES (:id_article, :designation, :prix, :categorie)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_article', $id_article);
            $stmt->bindParam(':designation', $designation);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    }

    // Modifie l'article dans la bdd
    public function updateArticle($id_article, $designation, $prix, $categorie) {
        try {
            $sql = "UPDATE article SET designation = :designation, prix = :prix, categorie = :categorie WHERE id_article = :id_article";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':designation', $designation);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':categorie', $categorie);
            $stmt->bindParam(':id_article', $id_article);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }

    // Supprime l'article dans la bdd
    public function deleteArticle($id_article) {
        try {
            $sql = "DELETE FROM article WHERE id_article = :id_article";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_article', $id_article);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
            return false;
        }
    }

    // Liste des commandes et des clients
    public function commandes() {
        try {
            $sql = "SELECT commande.id_comm, client.id_client, client.civilite, client.nom, client.prenom, client.mail, 
                        CONCAT(client.adresse, ', ', client.code_postal, ' ', client.ville) AS adresse 
                    FROM client 
                    INNER JOIN commande 
                    ON client.id_client = commande.id_client";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
        }
    }
    
    // Récupère la somme total vendu par catégorie
    public function getVolumesParCategorie() {
        try {
            $sql = "SELECT article.categorie AS categorie, SUM(ligne.quantite * ligne.prix_unit) AS total
                    FROM article 
                    INNER JOIN ligne 
                    ON article.id_article = ligne.id_article 
                    GROUP BY article.categorie
                    ORDER BY total DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des volumes par catégorie : " . $e->getMessage();
        }
    }
    
    // Liste des articles déjà commander
    public function getArticles() {
        try {
            $sql = "SELECT article.id_article AS id_article, article.designation AS designation, 
                            article.prix AS prix, article.categorie AS categorie, 
                            SUM(ligne.quantite) AS quantite 
                    FROM article 
                    INNER JOIN ligne 
                    ON article.id_article = ligne.id_article 
                    GROUP BY article.id_article";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des articles : " . $e->getMessage();
        }
    }
    
    // Liste des articles non commander
    public function getArticlesNonCommander() {
        try {
            $sql = "SELECT * FROM article WHERE NOT EXISTS 
                    (SELECT 1 FROM ligne WHERE ligne.id_article = article.id_article)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des articles non commandés : " . $e->getMessage();
        }
    }

    public function getGainTotalParCategorie($categorie) {
        $query = "CALL gainTotalParCategorie(:categorie, @gain_total)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->execute();

        $result = $this->conn->query("SELECT @gain_total AS gain_total");
        return $result->fetch(PDO::FETCH_ASSOC)['gain_total'];
    }

}