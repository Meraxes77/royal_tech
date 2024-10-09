<?php

require_once 'database/database.php';

class Facture {
    private $conn;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Récupère les infos des clients et de leur commande pour créer un PDF
    public function getFactureById($id_comm) {
        try{
            $sql = "SELECT commande.id_comm, commande.date_comm, commande.id_client, client.civilite, client.nom, client.prenom, client.adresse, client.code_postal, client.ville, client.mail, ligne.id_article, article.designation, ligne.quantite, ligne.prix_unit 
                FROM commande 
                INNER JOIN client ON commande.id_client = client.id_client 
                INNER JOIN ligne ON commande.id_comm = ligne.id_comm 
                INNER JOIN article ON ligne.id_article = article.id_article 
                WHERE commande.id_comm = :id_comm";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id_comm' => $id_comm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Erreur, lors de la récuperation des infos facture : " . $e->getMessage();
            return false;
        }
    }
}
