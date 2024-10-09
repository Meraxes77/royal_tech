<?php

require_once 'database/database.php';

class User{

    private $conn;

    public $login;
    public $mdp;
    public $role;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login() {
        if (empty($this->login) || empty($this->mdp)) {
            return 'empty_fields'; // Indicateur pour les champs vides
        }
    
        try {
            $sql = "SELECT utilisateur.login AS login, utilisateur.mdp AS mdp, role.role AS role 
                    FROM utilisateur 
                    INNER JOIN role ON utilisateur.id_role = role.id_role 
                    WHERE login = :login LIMIT 0,1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':login', $this->login);
            $stmt->execute();
    
            $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->login = $row['login'];
                $this->role = $row['role'];
    
                // Vérification du mot de passe
                if (password_verify($this->mdp, $row['mdp'])) {
                    return true;
                } else {
                    return 'incorrect_password'; // Indicateur pour un mot de passe incorrect
                }
            } else {
                return 'user_not_found'; // Indicateur pour aucun utilisateur trouvé
            }
        } catch (PDOException $e) {
            return 'db_error'; // Indicateur pour une erreur de base de données
        }
    }
}