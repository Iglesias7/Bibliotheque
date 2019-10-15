<?php

// Vérifie si tous les champs dont les clés sont passées dans le tableau $fields sont
// présents dans le tableau $arr. Si pas de tableau passé en paramètre, on vérifie dans $_POST.
    function check_fields($fields, $arr=null) {
        if ($arr === null)
            $arr = $_POST;
        foreach($fields as $field) {
            if (!isset($arr[$field]))
                return false;
        }
        return true;
    }

    function isLoggedIn() {
        return check_fields(['userid', 'username', 'role'], $_SESSION);
    }

    function check_login()
    {
        global $logged_userid, $logged_username, $logged_role;
        if (!isLoggedIn())
            $this->redirect("main", "index");
        else {
            $logged_userid = $_SESSION['userid'];
            $logged_username = $_SESSION['username'];
            $logged_role = $_SESSION['role'];
        }
    }
    
    function get_logged_role() {
        return $_SESSION['role'];
    }

    function get_logged_userid() {
        return $_SESSION['userid'];
    }

    function get_logged_username() {
        return $_SESSION['username'];
    }

    function estAdmin() {
        return get_logged_role() === 'admin'; 
    }

    function estMAnager() {
        return get_logged_role() === 'manager'; 
    }

    function isMember() {
        return get_logged_role() === 'member'; 
    }
    
    function estAdmin_ou_estMAnager(){
        return estAdmin() || estMAnager();  
    }


    
    function check_admin() {
        check_login();
        if (!estAdmin())
            abort("You must have the 'admin' role");
    }

    function check_manager_or_admin() {
        check_login();
        if (!estAdmin() && !estManager())
            abort("You must have the 'manager' or the 'admin' role");
    }
?>
