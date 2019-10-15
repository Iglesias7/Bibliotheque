<?php //

require_once "framework/Model.php";


class Book extends Model {
    public $id;
    public $isbn;
    public $title;
    public $author;
    public $editor;
    public $picture;
    public $nbCopies;


    public function __construct($isbn, $title, $author, $editor, $picture, $nbCopies, $id=-1) {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->author = $author;
        $this->editor = $editor;
        $this->picture = $picture;
        $this->nbCopies = $nbCopies;
        $this->id = $id;
    }
    
    public function getBook(){
        return Book::get_Book_by_id($this->book)->title."(".Book::get_Book_by_id($this->book)->author.")";
    }

//    public function updateBook() {
//            self::execute("UPDATE book SET isbn=:isbn, title=:title, author=:author, editor=:editor, picture=:picture WHERE id=:id", 
//                    array("isbn"=>$this->isbn,"title"=>$this->title,"author"=>$this->author, "editor"=>$this->editor, "picture"=>$this->picture, "id"=>$this->id));
//        return $this;
//    }
    
    public function updateBookk() {
            self::execute("UPDATE book SET isbn=:isbn, title=:title, author=:author, editor=:editor, nbCopies=:nbCopies WHERE id=:id", 
                    array("isbn"=>$this->isbn,"title"=> $this->title,"author"=>$this->author, "editor"=>$this->editor, "nbCopies"=>$this->nbCopies, "id"=> $this->id));
        return $this;
    }
    
    public function addBook() {
        self::execute("INSERT INTO book(isbn,title, author, editor, picture, nbCopies) VALUES(:isbn,:title, :author, :editor, :picture, :nbCopies)", 
                array("isbn"=>$this->isbn,"title"=>$this->title,"author"=>$this->author, "editor"=>$this->editor, "picture"=>$this->picture, "nbCopies"=>$nbCopies));
        return $this;
    }
    
//    public function addBookNotPicture() {
//        self::execute("INSERT INTO book(isbn,title, author, editor) VALUES(:isbn,:title, :author, :editor)", 
//                array("isbn"=>$this->isbn,"title"=>$this->title,"author"=>$this->author, "editor"=>$this->editor));
//        return $this;
//    }
    
    public static function get_books() {
        $query = self::execute("SELECT * FROM book", array());
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Book($row["isbn"], $row["title"], $row["author"], $row["editor"], $row["picture"], $row["nbCopies"], $row["id"]);
        }
        return $results;
    }
    
    public static function get_booksNotRental() {
        $query = self::execute("SELECT * FROM book where book.id NOT IN (select book from rental)", array());
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $isbn = Book::validateISBN($row["isbn"]);
            $results[] = new Book($isbn, $row["title"], $row["author"], $row["editor"], $row["picture"], $row["nbCopies"], $row["id"]);
        }
        return $results;
    }
    
    public static function get_booksRentalUser($user) {
        $query = self::execute("SELECT * FROM book where book.id IN (select book from rental WHERE rentaldate is null and user = :user)", array("user"=>$user));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $isbn = Book::validateISBN($row["isbn"]);
            $results[] = new Book($isbn, $row["title"], $row["author"], $row["editor"], $row["picture"], $row["nbCopies"], $row["id"]);
        }
        return $results;
    }
    
    public static function delete_Book($id) {
        $query = self::execute("DELETE FROM book WHERE id=:id", array("id"=>$id));
        //$query->fetch();
    }
    
    public static function get_Book_by_id($id) {
        $query = self::execute("SELECT * FROM book WHERE id = :id", array("id"=>$id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"], $data["nbCopies"], $data["id"]);
        }
    }
    
    public static function get_Book_by_isbn($isbn) {
        $query = self::execute("SELECT * FROM book WHERE isbn = :isbn", array("isbn"=>$isbn));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"], $data["nbCopies"], $data["id"]);
        }
    }
    
    public static function get_Book_by_title($id) {
        $query = self::execute("SELECT * FROM book where title = :title", array("title"=>$id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Book($data["isbn"], $data["title"], $data["author"], $data["editor"], $data["picture"], $data["nbCopies"], $data["id"]);
        }
    }
    
    
    public static function filter($book){
        $results=[];
        $query = self::execute("SELECT * FROM book where book.id NOT IN (select book from rental) and (title like :title or author like :author or editor like :editor or isbn like :isbn)",
                          array("title"=>"%".$book."%", "author"=>"%".$book."%", "editor"=>"%".$book."%", "isbn"=>"%".$book."%"));
        $datas = $query->fetchAll(); 
        foreach ($datas as $data){
            $isbn = Book::validateISBN($data["isbn"]);
             $results[] = new Book($isbn, $data["title"], $data["author"], $data["editor"], $data["picture"], $data["nbCopies"], $data["id"]);
        }
        return $results;
        
    }

    public static function validate_photo($file) {
        $errors = [];
        if (isset($file['name']) && $file['name'] != '') {
            if ($file['error'] == 0) {
                $valid_types = array("image/gif", "image/jpeg", "image/png");
                if (!in_array($_FILES['image']['type'], $valid_types)) {
                    $errors[] = "Unsupported image format : gif, jpg/jpeg or png.";
                }
            } else {
                $errors[] = "Error while uploading file.";
            }
        }
        return $errors;
    }

    //pre : validate_photo($file) returns true
    public function generate_photo_name($file) {
        //note : time() est utilisé pour que la nouvelle image n'aie pas
        //       le meme nom afin d'éviter que le navigateur affiche
        //       une ancienne image présente dans le cache
        if ($_FILES['image']['type'] == "image/gif") {
            $saveTo = $this->pseudo . time() . ".gif";
        } else if ($_FILES['image']['type'] == "image/jpeg") {
            $saveTo = $this->pseudo . time() . ".jpg";
        } else if ($_FILES['image']['type'] == "image/png") {
            $saveTo = $this->pseudo . time() . ".png";
        }
        return $saveTo;
    }
    public function get_photo_by_id($id) {
        
        $query =self::execute("SELECT picture from book WHERE id=:id" ,  array("picture"=>$id));
        $datas = $query->fetchAll();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return  Book($data["picture"]);
        }
    }
    
    public function set_photo() {
        self::execute("UPDATE book SET picture=:picture WHERE id=:id", 
                    array("picture"=>$this->picture, "id"=>$this->id));
        return $this;
    }
    
    public static function validate_book($isbn, $title, $author, $editor) {
        $errors = [];
        $book = Book::get_Book_by_isbn($isbn);
        if (!$book) {
            
            if(!preg_match('#^[0-9]{13}$#',$isbn)){
                $errors[] = "L'isbn doit contenir uniquement des chiffres.";
            }
            
            if(!User::check_string_length($isbn, 13 , 13)) {
                $errors[] = "L'isbn doit avoir 13 chiffres.";
            }            
            
            if(empty($title)){
                $errors[] = "le titre est obligatoire.";
            }  

            if(empty($author)){
                $errors[] = "le nom de l'auteur est obligatoire.";
            } 
            
            if(empty($editor)){
                $errors[] = "le nom de l'editeur est obligatoire.";
            }
        } else {
            $errors[] = "l'isbn ".$isbn." existe déjà.";
        }
        return $errors;
    }
    
    public static function validateUpd_book($isbn, $title, $author, $editor) {
        $errors = [];
        $book = Book::get_Book_by_isbn($isbn);

            if(!preg_match('#^[0-9]{13}$#',$isbn)){
                $errors[] = "L'isbn doit contenir uniquement des chiffres.";
            }
            
            if(!User::check_string_length($isbn, 13 , 13)) {
                $errors[] = "L'isbn doit avoir 13 chiffres.";
            }            
            
            if(empty($title)){
                $errors[] = "le titre est obligatoire.";
            }  

            if(empty($author)){
                $errors[] = "le nom de l'auteur est obligatoire.";
            } 
            
            if(empty($editor)){
                $errors[] = "le nom de l'editeur est obligatoire.";
            }

        return $errors;
    }
    
    public static function validateISBN($isbn){
      
        $result1 = substr($isbn,0, 3);
        $result2 = substr($isbn,3, 1);
        $result3 = substr($isbn,4, 4);
        $result4 = substr($isbn,8, 4);
        $result5 = substr($isbn,-1, 1);
        
        $result = $result1."-".$result2."-".$result3."-".$result4."-".$result5;
        return $result;
    }
}
