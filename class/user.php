<?php
/**
 * Class for represent users
 */
class User
{
  private $db;
  const DB_HOST = "localhost";
  const DB_NAME = "codemanager";
  const DB_USERNAME = "root";
  const DB_PASSWORD = "";
  const TABLE_NAME = "users";

  private $pseudo;
  private $mail;

  function __construct($pseudo, $mail)
  {
    $this->pseudo = $pseudo;
    $this->mail = $mail;
    $this->db = self::dbConnect();
  }

  /**
   * Connect to the database and return it
   * @return PDO The database
   */
  public static function dbConnect(){
  	$db = new PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8', self::DB_USERNAME, self::DB_PASSWORD);
  	return $db;
  }

  /**
   * Check if an account already exists
   * @param  String $pseudo The user's pseudo
   * @param  String $mail The user's email
   * @return boolean If account already exists : true
   */
  public static function accountExist($pseudo, $mail){
    $db = self::dbConnect();
    $q = $db->prepare("SELECT pseudo FROM " . self::TABLE_NAME . " WHERE pseudo=? AND mail=?");
    $q->execute([$pseudo, $mail]);
    $data = $q->fetch();
    return isset($data['pseudo']);
  }

  public function getPseudo(){
    return $this->pseudo;
  }
  public function setPseudo($value){
    $this->pseudo = $value;
  }
  public function getMail(){
    return $this->mail;
  }
  public function setMail($value){
    $this->mail = $value;
  }
}
