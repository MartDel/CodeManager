<?php

/**
 * Class to manage user's projects
 */
class Project extends DatabaseManager
{
    private $id;
    private $name;
    private $author_id;
    private $description;
    private $remote;

    const TABLE_NAME = 'projects';

    function __construct($name, $author_id, $description, $remote){
        $this->name = $name;
        $this->author_id = $author_id;
        $this->description = $description;
        $this->remote = $remote;

        // Get project id
        $db = self::dbConnect();
        $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE name=:name AND author=:author_id');
        $query->execute([
            'name' => $this->name,
            'author_id' => $this->author_id
        ]);
        $data = $query->fetch();
        $query->closeCursor();
        $this->id = $data['id'];
    }

    // STATIC FUNCTIONS

    /**
     * Get a specific a user's specific project by id
     * @param string $name Project id
     * @param int $user_id User's id
     * @return Project The specific project
     */
    public static function getProjectById($id, $user_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=:id AND author=:author_id');
        $query->execute([
            'id' => $id,
            'author_id' => $user_id
        ]);
        $data = $query->fetch();
        $query->closeCursor();
        return new Project($data['name'], $data['author'], $data['description'], $data['remote']);
    }

    /**
     * Get a specific a user's specific project by name
     * @param string $name Project name
     * @param int $user_id User's id
     * @return Project The specific project
     */
    public static function getFirstProject($user_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE author=?');
        $query->execute([$user_id]);
        $data = $query->fetch();
        $query->closeCursor();
        return new Project($data['name'], $data['author'], $data['description'], $data['remote']);
    }

    /**
     * Check if a project is contained in the database
     * @param  int $id Project id
     * @param  int $user_id User's id
     * @return boolean If the project exists or not
     */
    public static function projectExist($id, $user_id){
        $db = self::dbConnect();
        $q = $db->prepare("SELECT id FROM " . self::TABLE_NAME . " WHERE id=:id AND author=:author");
        $q->execute([
            'id' => $id,
            'author' => $user_id
        ]);
        $data = $q->fetch();
        $q->closeCursor();
        return isset($data['id']);
    }

    /**
     * Get all user's projects from the database
     * @param  int $user_id User's id
     * @return Object[] All of user's projects
     */
    public static function getAllProjects($user_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT id, name, description FROM ' . self::TABLE_NAME . ' WHERE author=?');
        $query->execute([$user_id]);
        $r = null;
        while($data = $query->fetch()){
            $r[] = [
                'id' => $data['id'],
                'name' => $data['name'],
                'description' => $data['description']
            ];
        }
        $query->closeCursor();
        return $r;
    }

    // GETTERS

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getAuthorId(){
        return $this->author_id;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getRemote(){
        return $this->remote;
    }
}
