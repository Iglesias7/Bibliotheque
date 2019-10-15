<?php
require_once 'model/User.php';
require_once 'model/Book.php';
require_once 'model/Rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerRental extends Controller {
    
    //page d'accueil. 
    public function index() {
        $this->profile();
    }

    public function removeBooksPanier(){
//        $profileConnect = $this->get_user_or_redirect();
        
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }  
        
        $id = $_GET["param2"];
        $postuser = Book::get_Book_by_id($id);

        Rental::delete_Rental($postuser->id);
        $this->redirect("rental", "addBookPanier/$profile->username");  
    }

    public function addBookPanier(){
        $profileConnect = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }
        $errors = [];
        if (isset($_GET["param2"]) && $_GET["param2"] !== "") {
            
            $id = $_GET['param2'];
            
            $count = 0;
            $rental = Rental::get_rentals_by_user($profile->id);
            if($rental){
                foreach ($rental as $val => $value){
                    $count += 1;
                }
            }

            if($count < 5){
                $rental = new Rental($profile->id, $id, NULL, NULL);
                $rental->addRental();
            } else {
                $errors[] = "You can't rent more than five pounds.";
            } 
        }
        
        if(isset($_POST['user'])){
            $user = User::get_user_by_id($_POST['user']);
            $this->redirect("rental", "addBookPanier", $user->username);
        }

        $booksPanier = Book::get_booksRentalUser($profile->id);
        $books = Book::get_booksNotRental();
        $users = User::get_users();
        
        (new View("panier"))->show(array("profile" => $profile, "books" => $books, "booksPanier" => $booksPanier, 
            "profileConnect"=>$profileConnect, "users" => $users, "errors" => $errors));
    }
    
    public function filersBooks(){
        $profileConnect = $this->get_user_or_redirect();
        
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }

        
        $users = User::get_users();
        $booksPanier = Book::get_booksRentalUser($profile->id);

        if (isset($_POST['book'])) {
            $books = Book::filter($_POST['book']);
        }
        
        (new View("panier"))->show(array("profile" => $profile, "books" => $books, "booksPanier" => $booksPanier, "profileConnect"=>$profileConnect, "users" => $users));
    }
    
    public function confirmPanier(){
        $profile = $this->get_user_or_redirect();
        
        
        $id = $_GET["param1"];
        $postuser = Rental::get_rentals_by_user($id);
        
        foreach ($postuser as $value){
            if($value->rentaldate == null)
                $value->rentaldate = date('Y/m/d H:i:s');
            $value->updateRentaldate();
        }
        
        $this->redirect("rental", "addBookPanier/$profile->username"); 
    }
    
    public function clear(){
        $profile = $this->get_user_or_redirect();
        
        $id = $_GET["param1"];
        $postuser = Rental::get_rentals_by_user($id);
        
        foreach ($postuser as $value){
            if($value->rentaldate === NULL){
                $value->delete_Rental($value->book);
            }
        }
        $this->redirect("rental", "addBookPanier/$profile->username"); 
    }
    
    public function gestionBook(){
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }

        $rentals = Rental::get_rentalsRenntalNotNull();
        
        (new View("gestion"))->show(array("profile" => $profile, "rentals" => $rentals));
    }
        
    public function deleteRental(){
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param2"]) && $_GET["param2"] !== "") {
            $profile = User::get_user_by_name($_GET["param2"]);
        }

        $id = $_GET["param1"];
        $postuser = Rental::get_rental_by_id($id);

        $postuser->delete_Rental_by_id($id);

        $this->redirect("rental", "gestionBook/$profile->username"); 
    }

    public function returnDate(){
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param2"]) && $_GET["param2"] !== "") {
            $profile = User::get_user_by_name($_GET["param2"]);
        }

        $id = $_GET["param1"];
        $postuser = Rental::get_rental_by_id($id);
        var_dump($postuser);

        $postuser->returndate = date('Y-m-d H:i:s');
        $postuser->updateReturndate();

        $this->redirect("rental", "gestionBook/$profile->username"); 
    }
    
    public function filersBookGestion(){
        
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }
        
        if(isset($_POST['username']) || isset($_POST['book']) || isset($_POST['rentaldate']) || isset($_POST['returndate'])){
            $rentaldate = $_POST['rentaldate'];
            $book = $_POST['book'];
            $username = $_POST['username'];
            
            $rentals = Rental::filterRental($rentaldate, $book, $username);
        }

        (new View("gestion"))->show(array("profile" => $profile, "rentals" => $rentals));
    }
    
    
}