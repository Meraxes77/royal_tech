<?php

    require 'models/user.class.php';

    class UserController{

        // Controller de connexion utilisateur sur la page login
        public function loginPage() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    if (empty($_POST['login']) || empty($_POST['mdp'])) {
                        $error = "Veuillez remplir tous les champs !";
                    } else {
                        $user = new User();
                        $user->login = $_POST['login'];
                        $user->mdp = $_POST['mdp'];
        
                        $result = $user->login(); // Appel à la méthode login()
                        
                        // Gestion des erreurs en fonction du résultat
                        if ($result === true) {
                            session_start();
                            $_SESSION['login'] = $user->login;
                            $_SESSION['role'] = $user->role;
        
                            header("Location: index.php?action=commander");
                            exit();
                        } else {
                            // Gestion des messages d'erreur en fonction du retour
                            switch ($result) {
                                case 'empty_fields':
                                    $error = "Veuillez remplir tous les champs !";
                                    break;
                                case 'incorrect_password':
                                    $error = "Le login ou le mot de passe est incorrect.";
                                    break;
                                case 'user_not_found':
                                    $error = "Le login ou le mot de passe est incorrect.";
                                    break;
                                case 'db_error':
                                    $error = "Erreur lors de la connexion à la base de données.";
                                    break;
                                default:
                                    $error = "Une erreur inconnue est survenue.";
                            }
                        }
                    }
                } catch (Exception $e) {
                    $error = "Erreur lors de la connexion : " . $e->getMessage();
                }
            }
        
            // Affichage de la vue avec les messages d'erreur
            require 'views/login.php';
        }

        // Vérifier si l'utilisateur est connecté
        public function isAuthenticated() {
            session_start();
            if (!isset($_SESSION['login'])) {
                header("Location: index.php?action=login");
                exit();
            }
        }

        public function register() {
            $user = new User;
            $listeRole = $user->role();
        
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                try {
                    if (empty($_POST['login']) || empty($_POST['mdp'])) {
                        echo "Veuillez remplir tous les champs !";
                    } else {
                        $user->login = $_POST['login'];
                        $user->mdp = $_POST['mdp'];
                        $user->role = $_POST['role'];
        
                        if ($user->createUser()) {
                            echo "<script>alert('Compte créé avec succès !')</script>";
                        } else {
                            echo "<script>alert('Erreur lors de la création du compte.')</script>";
                        }
                    }
                } catch (Exception $e) {
                    echo "Erreur lors de l'enregistrement : " . $e->getMessage();
                }
            }
        
            require 'views/register.php';
        }

    }