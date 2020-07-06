<?php

/**
 * Class to represent users
 */
class User extends DatabaseManager
{
  private $pseudo;
  private $mail;

  const TABLE_NAME = "users";

  function __construct($pseudo, $mail)
  {
    $this->pseudo = $pseudo;
    $this->mail = $mail;
  }

  /**
   * Upload the new user to the database
   * @param  String $password The user's password
   */
  public function pushToDB($password){
    $db = self::dbConnect();
    $final_password = password_hash($password, PASSWORD_DEFAULT);
    $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(pseudo, password, mail) VALUES(:pseudo, :password, :mail)');
    $add->execute([
      'pseudo' => $this->pseudo,
      'password' => $final_password,
      'mail' => $this->mail
    ]);
  }

  /**
   * Check if an account already exists
   * @param  String $pseudo The user's pseudo
   * @param  String $mail The user's email
   * @return boolean If account already exists : true
   */
  public static function accountExist($pseudo, $mail){
    $db = self::dbConnect();
    $q = $db->prepare("SELECT pseudo, mail FROM " . self::TABLE_NAME . " WHERE pseudo=? OR mail=?");
    $q->execute([$pseudo, $mail]);
    $data = $q->fetch();
  	$q->closeCursor();
    return isset($data['pseudo']) || isset($data['mail']);
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
    if(isset($data['password'])) return $data['password'];
    else return null;
  }

  /**
   * Get an user by his login
   * @param String $login User's pseudo or email
   * @return User User object reprenting the current user
   */
  public static function getUserByLogin($login){
    $db = self::dbConnect();
    $query = $db->prepare('SELECT pseudo, mail FROM ' . self::TABLE_NAME . ' WHERE pseudo=? OR mail=?');
    $query->execute([$login, $login]);
    $data = $query->fetch();
    return new User($data['pseudo'], $data['mail']);
  }

  // GETTERS

  public function getPseudo(){
    return $this->pseudo;
  }
  public function getMail(){
    return $this->mail;
  }
}
