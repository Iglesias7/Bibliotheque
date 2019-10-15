<?php

require_once "framework/Model.php";


class Rental extends Model {
    
    public $user;
    public $book;
    public $rentaldate;
    public $returndate;
    public $id;

    public function __construct($user, $book, $rentaldate, $returndate, $id=-1) {
        $this->user = $user;
        $this->book = $book;
        $this->rentaldate = $rentaldate;
        $this->returndate = $returndate;
        $this->id = $id;
    }
    
    public function getUserName(){
        return User::get_user_by_id($this->user)->username;
    }
    
    public function getBook(){
        return Book::get_Book_by_id($this->book)->title."(".Book::get_Book_by_id($this->book)->author.")";
    }

    public function updateRental() {
            self::execute("UPDATE rental SET user=:user, book=:book, rentaldate=:rentaldate, returndate=:returndate WHERE id=:id", 
                    array("user"=>$this->user,"book"=>$this->book,"rentaldate"=>$this->rentaldate,"returndate"=>$this->returndate, "id"=>$this->id));
        return $this;
    }
    
    public function updateRentaldate() {
            self::execute("UPDATE rental SET rentaldate=:rentaldate WHERE id=:id", 
                    array("rentaldate"=>$this->rentaldate, "id"=>$this->id));
        return $this;
    }
    
    public function updateReturndate() {
            self::execute("UPDATE rental SET returndate=:returndate WHERE id=:id", 
                    array("returndate"=>$this->returndate, "id"=>$this->id));
        return $this;
    }
    
    public function addRental() {
        self::execute("INSERT INTO rental(user,book, rentaldate, returndate) VALUES(:user,:book, :rentaldate, :returndate)", 
                array("user"=>$this->user,"book"=>$this->book,"rentaldate"=>$this->rentaldate, "returndate"=>$this->returndate));
        return $this;
    }
    
    
    
    public static function get_rentals_by_user($id) {
        $query = self::execute("SELECT * FROM rental where user = :user", array("user" => $id));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }
    }
    
    public static function get_rentals() {
        $query = self::execute("SELECT * FROM rental", array());
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }
    }
    
    public static function get_rentalsRenntalNotNull() {
        $query = self::execute("SELECT * FROM rental WHERE rentaldate is not null", array());
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }
    }
    
    public static function get_rentalsRenntalNotNul($user) {
        $query = self::execute("SELECT * FROM rental WHERE rentaldate is not null and user = :user", array("user"=>$user));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }
    }
    
    public static function get_rental_by_book($id, $user) {
        $query = self::execute("SELECT * FROM rental where book = :book and user = :user", array("book" => $id, "user" => $user));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["user"], $data["book"], $data["rentaldate"], $data["returndate"], $data["id"]);
        }
    }
    
    public static function get_count($user) {
        $query = self::execute("SELECT count(*) FROM rental Where exists (select * from rental where user = :user)", array("user" => $user));
        $data = $query->fetch();
        return $data;
    }
    
    public static function get_rental_by_books($id) {
        $query = self::execute("SELECT * FROM rental where book = :book", array("book" => $id));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["user"], $data["book"], $data["rentaldate"], $data["returndate"], $data["id"]);
        }
    }
    
    
    public static function get_rentall_by_book($id, $user) {
        $query = self::execute("SELECT * FROM rental where book = :book and user = :user", array("book" => $id, "user" => $user));
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }
    }
    
    public static function get_rental_by_users($id) {
        $query = self::execute("SELECT * FROM rental where user = :user", array("user" => $id));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["user"], $data["book"], $data["rentaldate"], $data["returndate"], $data["id"]);
        } 
    }
    
    public static function  get_rental_by_id($id) {
        $query = self::execute("SELECT * FROM rental where id = :id", array("id" => $id));
        $data = $query->fetch();
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new Rental($data["user"], $data["book"], $data["rentaldate"], $data["returndate"], $data["id"]);
        } 
    }
    
    public static function delete_Rental($book) {
        $query = self::execute("DELETE FROM rental WHERE book=:book", array("book"=>$book));
    }
    
    public static function delete_Rental_by_id($id) {
        $query = self::execute("DELETE FROM rental WHERE id = :id", array("id"=>$id));
    }
    
    public static function filterRental($rentaldate, $book, $username){
        $query = self::execute("SELECT rental.id, rental.user, rental.book, rentaldate, returndate FROM rental , book , user "
                . "where book = book.id and user = user.id and rentaldate like :rentaldate "
                . "and (title like :title or author like :author) and username like :username" 
                , array("rentaldate"=>"%".$rentaldate."%", "title"=>"%".$book."%", "author"=>"%".$book."%", "username"=>"%".$username."%"));
        $data = $query->fetchAll(); 
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }    
    }
    
    public static function filterRentalNull(){
        $query = self::execute("SELECT * FROM rental whererentaldate is not null and returndate is null" , array());
        $data = $query->fetchAll(); 
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }    
    }
    
    public static function filterRentalLocationAchevées(){
        $query = self::execute("SELECT * FROM rental where rentaldate is not null and returndate is not null" , array());
        $data = $query->fetchAll(); 
        $results = [];
        foreach ($data as $row) {
            $results[] = new Rental($row["user"], $row["book"], $row["rentaldate"], $row["returndate"], $row["id"]);
        }
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return $results;
        }    
    }
}
