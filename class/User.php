<?php

/**
 * Class to represent users
 */
class User extends DatabaseManager
{
    private $pseudo;
    private $mail;
    private $firstname;
    private $lastname;
    private $role;

    const TABLE_NAME = "users";

    function __construct($pseudo, $mail, $firstname, $lastname)
    {
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    /**
    * Upload the new user to the database
    * @param  String $password The user's password
    */
    public function pushToDB($password){
        $db = self::dbConnect();
        $final_password = password_hash($password, PASSWORD_DEFAULT);
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(pseudo, password, mail, firstname, lastname) VALUES(:pseudo, :password, :mail, :firstname, :lastname)');
        $add->execute([
            'pseudo' => $this->pseudo,
            'password' => $final_password,
            'mail' => $this->mail,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ]);
    }

    /**
    * Check if an account already exists
    * CAN BE OPTIMISE : NOT STATIC BUT OBJECT FUNCTION
    * @param String $pseudo The user's pseudo
    * @param String $mail The user's email
    * @param String $firstname The user's firstname
    * @param String $lastname The user's lastname
    * @return boolean If account already exists : true
    */
    public static function accountExist($pseudo, $mail, $firstname, $lastname){
        $db = self::dbConnect();
        $q = $db->prepare("SELECT pseudo, mail FROM " . self::TABLE_NAME . " WHERE pseudo=? OR mail=? OR (firstname=? AND lastname=?)");
        $q->execute([$pseudo, $mail, $firstname, $lastname]);
        $data = $q->fetch();
        $q->closeCursor();
        return isset($data['pseudo']) || isset($data['mail']) || isset($data['firstname']) || isset($data['lastname']);
    }

    /**
    * Get the user's password from his login
    * @param String $login User's username or email
    * @return String User's password (or null if it doesn't exist)
    */
    public static function getPassword($login){
        $db = self::dbConnect();
        $pass_query = $db->prepare('SELECT password FROM ' . self::TABLE_NAME . ' WHERE pseudo=? OR mail=?');
        $pass_query->execute([$login, $login]);
        $data = $pass_query->fetch();
        return isset($data['password']) ? $data['password'] : null;
        // if(isset($data['password'])) return $data['password'];
        // else return null;
    }

    /**
    * Get an user by his login
    * @param String $login User's pseudo or email
    * @return User User object reprenting the current user
    */
    public static function getUserByLogin($login){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT pseudo, mail, firstname, lastname FROM ' . self::TABLE_NAME . ' WHERE pseudo=? OR mail=?');
        $query->execute([$login, $login]);
        $data = $query->fetch();
        return new User($data['pseudo'], $data['mail'], $data['firstname'], $data['lastname']);
    }

    // GETTERS

    public function getPseudo(){
        return $this->pseudo;
    }
    public function getMail(){
        return $this->mail;
    }
    public function getFirstname(){
        return $this->firstname;
    }
    public function getLastname(){
        return $this->lastname;
    }
    public function getRole(){
        return $this->role;
    }
}
