<?php
require_once 'model/Rental.php';
require_once 'model/Book.php';
require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerUser extends Controller {
    

    
  

    //page d'accueil. 
    public function index() {
        $this->profile();
    }

    //profil de l'utilisateur connecté ou donné
    public function profile() {
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }
        
//        $currently = [];
        $currently = Rental::get_rentalsRenntalNotNul($profile->id);
 
//        foreach ($rental as $value){
//            if($value->rentaldate !== NULL){
//                $name = Book::get_Book_by_id($value->book);
//                $date = $value->rentaldate;
//                $currently[] = array($value->rentaldate, $name->title."(".$name->author.")", date('Y-m-d H:i:s',strtotime('1 month',strtotime($date))), $value->returndate);
//            } 
//        }
        
        (new View("profile"))->show(array("profile" => $profile, "currently" => $currently));
    }

    //liste des utilisateurs.
    public function users() {
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }
        $users = User::get_users();
        (new View("users"))->show(array("profile" => $profile, "users" => $users));
    }
    
    //gestion de l'ajout d'un utilisateur
    public function add() {
        $profile = $this->get_user_or_redirect();
        $username = '';
        $password = '';
        $fullname = '';
        $email = '';
        $birthdate = '';
        $role = "";
        $errors = [];

        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['fullname']) && isset($_POST['birthdate'])){
            $username = trim($_POST['username']);
            $password = $username;
            $fullname = trim($_POST['fullname']);
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            
            if($profile->role === 'manager'){
                $role = 'member';
            } else {
                $role = $_POST['role'];
            }
            

            $user = new User($username, Tools::my_hash($password), $fullname, $email, $birthdate, $role);
            $errors = User::validate_unicity($username);
            $errors = User::validate_user($fullname, $email, $birthdate);
            $errors = array_merge($errors, $user->validate());
            $errors = User::validate_unicity_email($email);
 

            if (count($errors) == 0) { 
                $user->add(); //sauve l'utilisateur
                $this->redirect("user", "users");
            }
        }
        (new View("add"))->show(array("profile" => $profile, "username" => $username,
            "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role, "errors" => $errors));
    }
    
    
      //gestion de l'update d'un utilisateur
    public function upd() {
        $profile = $this->get_user_or_redirect();

            $id = $_GET["param1"];
            $postuser = User::get_user_by_id($id);
            
            if(isset($_POST['edit'])){
                $username = $postuser->username;
                $fullname = $postuser->fullname;
                $email = $postuser->email;
                $birthdate = $postuser->birthdate;
                $role = $postuser->role;
            }
            
        $errors = [];

        if(isset($_POST['username'])  || isset($_POST['email']) || isset($_POST['fullname']) || isset($_POST['birthdate'])){
            
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $role = $_POST['role'];
            
            $postuser->username = $username;
            $postuser->fullname = $fullname;
            $postuser->email = $email;
            $postuser->birthdate = $birthdate;
            $postuser->role = $role;
            
            $errors = array_merge($errors, $postuser->validate());
            $errors = User::validate_user($fullname, $email, $birthdate);
            

            if (count($errors) == 0) { 
                $postuser->update(); //sauve l'utilisateur
                $this->redirect("user", "users");
            }
        }
        (new View("edit"))->show(array("profile" => $profile, "postuser" => $postuser, "username" => $username,
            "fullname" => $fullname, "email" => $email, "birthdate" => $birthdate, "role" => $role, "errors" => $errors));
    }
    
    public function delete() {
        $profile = $this->get_user_or_redirect();
        
        if(isset($_POST['delete'])){
            $id = $_GET["param1"];
            $postuser = User::get_user_by_id($id);
        }
        
        if (isset($_POST['delet'])) {
            $id = $_POST["delet"];
            $postuser = User::get_user_by_id($id);

            if($profile->role !== 'member'){
                
                $rental = Rental::get_rentals_by_user($id);
                foreach ($rental as $value){
                    Rental::delete_Rental_by_id($value->id);
                }
                
                $postuser->delete_user($postuser->id);
                $this->redirect("user", "users");
            }else{
               abort( "Vous ne pouvez pas supprimer un administrateur.");
            } 
        }
        (new View("delete"))->show(array("profile" => $profile, "postuser" => $postuser));
    }
}


