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

    public function createUser() {
        try {
            $sql = "INSERT INTO utilisateur (login, mdp, id_role) VALUES (:login, :mdp, :role)";
            $stmt = $this->conn->prepare($sql);

            // Nettoyage des entrées
            $cleaned_login = htmlspecialchars(strip_tags($this->login));
            $cleaned_role = htmlspecialchars(strip_tags($this->role));

            // Hachage du mot de passe
            $hashed_password = password_hash($this->mdp, PASSWORD_BCRYPT);

            // Liaison des paramètres
            $stmt->bindParam(':login', $cleaned_login);
            $stmt->bindParam(':mdp', $hashed_password);
            $stmt->bindParam(':role', $cleaned_role);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function role() {
        try {
            $listRole = array();
            $sql = "SELECT id_role, role FROM `role`";
            foreach ($this->conn->query($sql) as $row) {
                $listRole[] = $row;
            }
            return $listRole;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des rôles : " . $e->getMessage();
            return [];
        }
    }
}