<?php

require_once "framework/Model.php";


class User extends Model {
    public $id;
    public $username;
    public $hashed_password;
    public $fullname;
    public $email;
    public $birthdate;
    public $role;

    public function __construct($username, $hashed_password, $fullname, $email, $birthdate,$role = 'member',$id=-1) {
        $this->username = $username;
        $this->hashed_password = $hashed_password;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->role = $role;
        $this->id = $id;
    }

    public function update() {
            self::execute("UPDATE user SET username=:username, fullname=:fullname, email=:email, birthdate=:birthdate, role=:role WHERE id=:id", 
                    array("username"=>$this->username,"fullname"=>$this->fullname,"email"=>$this->email,"birthdate"=>$this->birthdate, "role"=>$this->role, "id"=>$this->id));
        return $this;
    }
    
    
    public function add() {
        self::execute("INSERT INTO user(username,password, fullname, email, birthdate, role) VALUES(:username,:password, :fullname, :email, :birthdate, :role)", 
                array("username"=>$this->username, "password"=>$this->hashed_password,"fullname"=>$this->fullname,"email"=>$this->email,"birthdate"=>$this->birthdate,"role"=>$this->role));
        return $this;
    }
    
    public static function get_user_by_id($id) {
        $query = self::execute("SELECT * FROM user where id = :id", array("id"=>$id));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["username"], $data["password"], $data["fullname"], $data["email"], $data["birthdate"], $data["role"], $data["id"]);
        }
    }
    
    public static function get_user_by_name($username) {
        $query = self::execute("SELECT * FROM user where username = :username", array("username"=>$username));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["username"], $data["password"], $data["fullname"], $data["email"], $data["birthdate"], $data["role"], $data["id"]);
        }
    }

    public static function get_user_by_email($email) {
        $query = self::execute("SELECT * FROM user where email = :email", array("email"=>$email));
        $data = $query->fetch(); // un seul résultat au maximum
        if ($query->rowCount() == 0) {
            return false;
        } else {
            return new User($data["username"], $data["password"], $data["fullname"], $data["email"], $data["birthdate"], $data["role"], $data["id"]);
        }
    }
    
    public static function get_users() {
        $query = self::execute("SELECT * FROM user", array());
        $data = $query->fetchAll();
        $results = [];
        foreach ($data as $row) {
            $results[] = new User($row["username"], $row["password"], $row["fullname"], $row["email"], $row["birthdate"], $row["role"], $row["id"]);
        }
        return $results;
    }
    
    static function delete_user($id) {
        $query = self::execute("DELETE FROM user WHERE id=:id", array("id"=>$id));
        //$query->fetch();
    }
    
    function count_admins() {
        $query = self::execute("SELECT count(*) from user where role='admin'");
        $row = $query->fetch();
        return (int)$row[0];
    }
    
    public static function check_string_length($str, $min, $max) {
        $len = strlen(trim($str));
        return $len >= $min && $len <= $max;
    }
    
    
    
//    function check_fields($fields, $arr=null) {
//    if ($arr === null)
//        $arr = $_POST;
//    foreach($fields as $field) {
//        if (!isset($arr[$field]))
//            return false;
//    }
//    return true;
//}
    /* ======================================= */
/* ===  Fonctions de gestion des dates === */
/* ======================================= */

// Vérifie si une date passée en string au format YYYY-MM-DD est valide
    public static function is_valid_date($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    // Retourne une date au format YYYY-MM-DD à partir d'une string conforme à celles attendues par strtotime
    public static function get_date($str) {
        $ts = strtotime($str);
        $d = new DateTime();
        $d->setTimestamp($ts);
        return $d->format('Y-m-d');
    }

    // Formatte une date, donnée dans le format YYYY-MM-DD, au format d'affichage DD/MM/YYYY
    function format_date($date) {
        return $date === null ? '' : (new DateTime($date))->format('d/m/Y');
    }
    
    
    private static function validate_password($password){
        $errors = [];
        if (strlen($password) < 8 || strlen($password) > 16) {
            $errors[] = "Password length must be between 8 and 16.";
        } if (!((preg_match("/[A-Z]/", $password)) && preg_match("/\d/", $password) && preg_match("/['\";:,.\/?\\-]/", $password))) {
            $errors[] = "Password must contain one uppercase letter, one number and one punctuation mark.";
        }
        return $errors;
    }
    
    public static function validate_passwords($password, $password_confirm){
        $errors = USer::validate_password($password);
        if ($password != $password_confirm) {
            $errors[] = "You have to enter twice the same password.";
        }
        return $errors;
    }
    
    public static function validate_unicity($username){
        $errors = [];
        $user = self::get_user_by_name($username);
        if ($user) {
            $errors[] = "This user already exists.";
        } 
        return $errors;
    }
    
    public static function validate_unicity_email($email){
        $errors = [];
        $user = self::get_user_by_name($email);
        if ($user) {
            $errors[] = "This user already exists.";
        } 
        return $errors;
    }

    //indique si un mot de passe correspond à son hash
    private static function check_password($clear_password, $hash) {
        return $hash === Tools::my_hash($clear_password);
    }

    //renvoie un tableau d'erreur(s) 
    //le tableau est vide s'il n'y a pas d'erreur.
    //ne s'occupe que de la validation "métier" des champs obligatoires (le pseudo)
    //les autres champs (mot de passe, description et image) sont gérés par d'autres
    //méthodes.
    public function validate(){
        $errors = array();
        if (!(isset($this->username) && is_string($this->username) && strlen($this->username) > 0)) {
            $errors[] = "username is required.";
        } if (!(isset($this->username) && is_string($this->username) && strlen($this->username) >= 3 && strlen($this->username) <= 16)) {
            $errors[] = "username length must be between 3 and 16.";
        } if (!(isset($this->username) && is_string($this->username) && preg_match("/^[a-zA-Z][a-zA-Z0-9]*$/", $this->username))) {
            $errors[] = "username must start by a letter and must contain only letters and numbers.";
        }
        return $errors;
    }
    
    public static function validate_user($fullname, $email, $birthdate) {
        $errors = [];

        if(empty($fullname)){
            $errors[] = "Full Name is required.";
        }  
        elseif(!User::check_string_length($fullname, 3, 255)) {
            $errors[] = "Full Name length must be between 3 and 255 characters.";
        } 
        if(empty($email)){
            $errors[] = "Email is required.";
        } 
        elseif(!User::check_string_length($email, 5, 64)) {
            $errors[] = "Email length must be between 5 and 64 characters.";
        } 
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email address is not valid";
        }
       
        if (!empty($birthdate)) {
            
            $tsp = strtotime($birthdate);
            $tsp1 = strtotime('1982-01-01');
            $tsp2 = time();
            $tsp4 = $tsp2 -$tsp1;

            if($tsp > $tsp4){
                $errors[] = "User must be at least 18 years old";
            }
            
//            if (!User::is_valid_date($birthdate)) {
//                $errors[] = "Birth Date is not valid";
//            }
//            if ($birthdate > User::get_date('-18 years')) {
//                $errors[] = "User must be at least 18 years old";
//            }
        }
        return $errors;
    }
    
    //renvoie un tableau d'erreur(s) 
    //le tableau est vide s'il n'y a pas d'erreur.
    public static function validate_login($username, $password) {
        $errors = [];
        $user = User::get_user_by_name($username);
        if ($user) {
            if (!self::check_password($password, $user->hashed_password)) {
                $errors[] = "Wrong password. Please try again.";
            }
        } else {
            $errors[] = "Can't find a member with the pseudo '$username'. Please sign up.";
        }
        return $errors;
    }
    

}
