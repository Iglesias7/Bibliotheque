<?php

require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerMain extends Controller {

    //si l'utilisateur est conecté, redirige vers son profil.
    //sinon, produit la vue d'accueil.
    public function index() {
        if ($this->user_logged()) {
            $this->redirect("user", "profile");
        } else {
            $this->login();
        }
    }
    
     //gestion de la connexion d'un utilisateur
    public function login() {
        $username = '';
        $password = '';
        $errors = [];
        if (isset($_POST['username']) && isset($_POST['password'])) { //note : pourraient contenir
        //des chaînes vides
            $username = $_POST['username'];
            $password = $_POST['password'];

            $errors = User::validate_login($username, $password);
            if (empty($errors)) {
                $this->log_user(User::get_user_by_name($username));
            }
        }
        (new View("index"))->show(array("username" => $username, "password" => $password, "errors" => $errors));
    }
    
    //gestion de l'inscription d'un utilisateur
    public function signup() {
        
        $username = '';
        $password = '';
        $password_confirm = '';
        $fullname = '';
        $email = '';
        $birthdate = '';
        $errors = [];

        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['email'])
                && isset($_POST['fullname'])){
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            
            if(isset($_POST['birthdate'])){
                $birthdate = $_POST['birthdate'];
            }else{
                $birthdate = NULL;
            }
            

            $user = new User($username, Tools::my_hash($password), $fullname, $email, $birthdate);
            $errors = User::validate_unicity($username);
            $errors = User::validate_unicity_email($email);
            $errors = User::validate_user($fullname, $email, $birthdate);
            $errors = array_merge($errors, $user->validate());
            $errors = array_merge($errors, User::validate_passwords($password, $password_confirm));

            if (count($errors) == 0) { 
                $user->add(); //sauve l'utilisateur
                $this->log_user($user);
            }
        }
        (new View("signup"))->show(array("username" => $username, "password" => $password, "password_confirm" => $password_confirm, 
            "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "errors" => $errors));
    }

}

