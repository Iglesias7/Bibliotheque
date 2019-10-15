    
<?php
require_once 'model/User.php';
require_once 'model/Book.php';
require_once 'model/Rental.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';
require_once 'framework/Utils.php';

class ControllerBook extends Controller {
    
    const UPLOAD_ERR_OK = 0;
    
    //page d'accueil. 
    public function index() {
        $this->profile();
    }
    


    public function books(){

        $profile = $this->get_user_or_redirect();
        
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }
        
//        $panier = Rental::get_rentals_by_user($profile->id);
        $books = Book::get_Books();
        
        (new View("panier"))->show(array("profile" => $profile, "books" => $books));
    }
    
    public function addBook(){
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param1"]) && $_GET["param1"] !== "") {
            $profile = User::get_user_by_name($_GET["param1"]);
        }
        
        $isbn = '';
        $title = '';
        $author = '';
        $editor = '';
        $picture = '';
        $nbCopies = '';
        $errors = [];
        
        if(isset($_POST['isbn']) && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['editor']) && isset($_POST['nbCopies'])){
            $isbn = trim($_POST['isbn']);
            $title = $_POST['title'];
            $author = $_POST['author'];
            $editor = $_POST['editor'];
            $nbCopies = $_POST['nbCopies'];
            
            
            $errors = Book::validate_book($isbn, $title, $author, $editor);
            if((empty($errors))){
                $book = new Book($isbn, $title, $author, $editor, null, $nbCopies);
            
                if (isset($_FILES['image']) && $_FILES['image']['error'] === self::UPLOAD_ERR_OK) {
                    $errors = Book::validate_photo($_FILES['image']);
                    if (empty($errors)) {
                        $saveTo = $book->generate_photo_name($_FILES['image']);
                        $oldFileName = $book->picture;
                        if ($oldFileName && file_exists("upload/" . $oldFileName)) {
                            unlink("upload/" . $oldFileName);
                        }
                        move_uploaded_file($_FILES['image']['tmp_name'], "upload/$saveTo");
                        $book->picture = $saveTo;
                    } 
                }

                $book->addBook();
                $this->redirect("rental", "addBookPanier", $profile->username);
            }
        }
            
 
        (new View("bookAdd"))->show(array("profile" => $profile, "isbn" => $isbn,
            "title" => $title, "author" => $author, "editor" => $editor, "picture" => $picture, "nbCopies"=>$nbCopies, "errors" => $errors));
    }
    
    public function updBook(){      
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param2"]) && $_GET["param2"] !== "") {
            $profile = User::get_user_by_name($_GET["param2"]);
        }
        
        $id = $_GET["param1"];
        $postuser = Book::get_Book_by_id($id);
        
        
        
        if(isset($_POST['edit'])){
            $isbn = $postuser->isbn;
            $title = $postuser->title;
            $author = $postuser->author;
            $editor = $postuser->editor;
            $picture = $postuser->picture;    
            $nbCopies = $postuser->nbCopies;  
        }
        
        $errors = [];

        if(isset($_POST['clear'])){
            $isbn = $postuser->isbn;
            $title = $postuser->title;
            $author = $postuser->author;
            $editor = $postuser->editor;
            $picture = $postuser->picture;
            $nbCopies = $postuser->nbCopies; 
            
            $postuser->picture = null;
            $postuser->set_photo();
            $this->redirect("book", "updBook/$postuser->id");
        }
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === self::UPLOAD_ERR_OK) {
            $errors = Book::validate_photo($_FILES['image']);
            if (empty($errors)) {
                $saveTo = $postuser->generate_photo_name($_FILES['image']);
                $oldFileName = $postuser->picture;
                if ($oldFileName && file_exists("upload/" . $oldFileName)) {
                    unlink("upload/" . $oldFileName);
                }
                move_uploaded_file($_FILES['image']['tmp_name'], "upload/$saveTo");
                $postuser->picture = $saveTo;
                $postuser->set_photo();
            } 
        }

        if(isset($_POST['isbn'])  && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['editor']) && isset($_POST['nbCopies'])){
            
            $isbn = $_POST['isbn'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $editor = $_POST['editor'];
            $nbCopies = $_POST['nbCopies'];

            $postuser->isbn = $isbn;
            $postuser->title = $title;
            $postuser->author = $author;
            $postuser->editor = $editor;
            $postuser->nbCopies = $nbCopies; 
            
//            $errors = Book::validateUpd_book($isbn, $title, $author, $editor);
            
            if((empty($errors))){
                $postuser->updateBookk();
                $this->redirect("rental", "addBookPanier/$profile->username");
            }else{
                $this->redirect("book", "updBook/$postuser->id");
            }
        }
        (new View("bookEdit"))->show(array("postuser" => $postuser, "profile" => $profile, "errors" => $errors));
    }
    
    public function deleteBook() {
        $profile = $this->get_user_or_redirect();
        
        $id = $_GET["param1"];
        $postuser = Book::get_Book_by_id($id);

        if (isset($_POST['delet'])) {
            if(Rental::get_rental_by_book($id, $profile->id)){
                Rental::delete_Rental($id);
            }
            
            Book::delete_Book($id);
            $this->redirect("rental", "addBookPanier/$profile->username");
        }
        
        (new View("deleteBook"))->show(array("profile" => $profile, "postuser" => $postuser));
    }
    
    
    public function showBook(){
        $profile = $this->get_user_or_redirect();
        if (isset($_GET["param2"]) && $_GET["param2"] !== "") {
            $profile = User::get_user_by_name($_GET["param2"]);
        }
        
        $id = $_GET["param1"];
        $postuser = Book::get_Book_by_id($id);
        
        $isbn = $postuser->isbn;
        $isbn = Book::validateISBN($isbn);
        $title = $postuser->title;
        $author = $postuser->author;
        $editor = $postuser->editor;
        $picture = $postuser->picture;    
        $nbCopies = $postuser->nbCopies; 
        

    
        (new View("showBook"))->show(array("postuser" => $postuser, "profile" => $profile, "isbn" => $isbn,
            "title" => $title, "author" => $author, "editor" => $editor, "picture" => $picture, "nbCopies" => $nbCopies));
    }
   
}

