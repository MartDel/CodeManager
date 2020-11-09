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
        try {
            $db = self::dbConnect();
            $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE name=:name AND author_id=:author_id');
            $query->execute([
                'name' => $this->name,
                'author_id' => $this->author_id
            ]);
            $data = $query->fetch();
            $query->closeCursor();
            $this->id = isset($data['id']) ? $data['id'] : null;
        } catch (Exception $e) {
            $this->id = null;
        }

    }

    /**
     * Add project to the database
     */
    public function pushToDB(){
        $db = self::dbConnect();
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(name, author_id, description, remote) VALUES(:name, :author, :description, :remote)');
        $add->execute([
            'name' => $this->name,
            'author' => $this->author_id,
            'description' => $this->description ? $this->description : null,
            'remote' => $this->remote ? $this->remote : null
        ]);
        $add->closeCursor();
    }

    /**
     * Update project from the database
     */
    public function update($project_id){
        $db = self::dbConnect();
        $update = $db->prepare('UPDATE ' . self::TABLE_NAME . ' SET name=:name, description=:description, remote=:remote WHERE id=:id');
        $update->execute([
            'name' => $this->name,
            'description' => $this->description ? $this->description : null,
            'remote' => $this->remote ? $this->remote : null,
            'id' => $project_id
        ]);
        $update->closeCursor();
    }

    /**
     * Delete a project from the database
     */
    public function delete(){
        $db = self::dbConnect();

        $del = $db->prepare('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=?');
        $del->execute([$this->id]);

        $del = $db->prepare('DELETE FROM ' . Task::TABLE_NAME . ' WHERE project_id=?');
        $del->execute([$this->id]);

        $del->closeCursor();
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
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=:id AND author_id=:author_id');
        $query->execute([
            'id' => $id,
            'author_id' => $user_id
        ]);
        $data = $query->fetch();
        $query->closeCursor();
        return new Project($data['name'], $data['author_id'], $data['description'], $data['remote']);
    }

    /**
     * Get a specific a user's specific project by name
     * @param string $name Project name
     * @param int $user_id User's id
     * @return Project The specific project
     */
    public static function getFirstProject($user_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE author_id=?');
        $query->execute([$user_id]);
        $data = $query->fetch();
        $query->closeCursor();
        return isset($data['id']) ? new Project($data['name'], $data['author_id'], $data['description'], $data['remote']) : null;
    }

    /**
     * Check if a project is contained in the database
     * @param  int $id Project id
     * @param  int $user_id User's id
     * @return boolean If the project exists or not
     */
    public static function projectExist($id, $user_id){
        $db = self::dbConnect();
        $q = $db->prepare("SELECT id FROM " . self::TABLE_NAME . " WHERE id=:id AND author_id=:author");
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
        $query = $db->prepare('SELECT id, name, description FROM ' . self::TABLE_NAME . ' WHERE author_id=?');
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

    public function getDatabaseId(){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE name=:name AND author_id=:author_id');
        $query->execute([
            'name' => $this->name,
            'author_id' => $this->author_id
        ]);
        $data = $query->fetch();
        $query->closeCursor();
        return isset($data['id']) ? $data['id'] : null;
    }

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
    public function getFullRemote(){
        return $this->remote;
    }
    public function getRemotePseudo(){
        $infos = explode('/', substr($this->remote, 19));
        if(count($infos) == 2) return $infos[0];
        return null;
    }
    public function getRemoteName(){
        $infos = explode('/', substr($this->remote, 19));
        if(count($infos) == 2) return $infos[1];
        else return null;
    }
}
