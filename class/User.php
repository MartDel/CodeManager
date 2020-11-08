<?php

/**
 * Class to represent users
 */
class User extends DatabaseManager
{
    private $id;
    private $pseudo;
    private $mail;
    private $firstname;
    private $lastname;
    private $picture;
    // private $role;

    const TABLE_NAME = "users";

    function __construct($pseudo, $mail, $firstname, $lastname)
    {
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        try {
            $db = self::dbConnect();

            // Get user's id and picture name
            $query = $db->prepare('SELECT id, picture FROM ' . self::TABLE_NAME . ' WHERE pseudo=:pseudo AND mail=:mail');
            $query->execute([
                'pseudo' => $this->pseudo,
                'mail' => $this->mail
            ]);
            $data = $query->fetch();
            $query->closeCursor();
            $this->id = isset($data['id']) ? $data['id'] : null;
            $this->picture = isset($data['picture']) ? $data['picture'] : null;
        } catch (Exception $e) {
            $this->id = null;
            $this->picture = null;
        }

    }

    /**
    * Upload the new user to the database
    * @param  string $password The user's password
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
        $add->closeCursor();
    }

    /**
     * Set the user's picture in the database
     * @param String $name Picture name
     */
    public function setPictureName($name){
        $db = self::dbConnect();
        $set = $db->prepare("UPDATE " . self::TABLE_NAME . " SET picture = :pname WHERE id=:id");
        $set->execute([
            'pname' => $name,
            'id' => $this->id
        ]);
        $set->closeCursor();
        $this->picture = $name;
    }

    /**
     * Delete an user from the database
     */
    public function delete(){
        $db = self::dbConnect();
        $del = $db->prepare('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=?');
        $del->execute([$this->id]);
    }

    /**
    * Check if an account already exists
    * @return boolean If account already exists : true
    */
    public function accountExist(){
        $db = self::dbConnect();
        $q = $db->prepare("SELECT pseudo, mail FROM " . self::TABLE_NAME . " WHERE pseudo=:pseudo OR mail=:mail OR (firstname=:firstname AND lastname=:lastname)");
        $q->execute([
            'pseudo' => $this->pseudo,
            'mail' => $this->mail,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ]);
        $data = $q->fetch();
        $q->closeCursor();
        return isset($data['pseudo']) || isset($data['mail']) || isset($data['firstname']) || isset($data['lastname']);
    }

    // STATIC FUNCTIONS

    /**
    * Get the user's password from his login
    * @param string $login User's username or email
    * @return string User's password (or null if it doesn't exist)
    */
    public static function getPassword($login){
        $db = self::dbConnect();
        $pass_query = $db->prepare('SELECT password FROM ' . self::TABLE_NAME . ' WHERE pseudo=? OR mail=?');
        $pass_query->execute([$login, $login]);
        $data = $pass_query->fetch();
        $pass_query->closeCursor();
        return isset($data['password']) ? $data['password'] : null;
    }

    /**
    * Get an user by his login
    * @param string $login User's pseudo or email
    * @return User User object reprenting the current user
    */
    public static function getUserByLogin($login){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE pseudo=? OR mail=?');
        $query->execute([$login, $login]);
        $data = $query->fetch();
        $query->closeCursor();
        return new User($data['pseudo'], $data['mail'], $data['firstname'], $data['lastname']);
    }

    // GETTERS

    public function getId(){
        return $this->id;
    }
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
    public function getPictureName(){
        return $this->picture;
    }
    // public function getRole(){
    //     return $this->role;
    // }
}
