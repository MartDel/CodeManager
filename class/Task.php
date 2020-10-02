<?php

/**
 * Class to represent a task
 */
class Task extends DatabaseManager
{
    private $id;
    private $name;
    private $project_id;
    private $is_done;
    private $create_date;
    private $author;
    private $description;

    const TABLE_NAME = "tasks";

    function __construct($name, $project_id, $is_done, $create_date, $author, $description)
    {
        $this->name = $name;
        $this->project_id = $project_id;
        $this->is_done = $is_done;
        $this->create_date = $create_date;
        $this->author = $author;
        $this->description = $description;

        // Get task id
        $db = self::dbConnect();
        $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE name=:name AND author=:author AND project_id=:project_id');
        $query->execute([
            'name' => $this->name,
            'author' => $this->author,
            'project_id' => $this->project_id
        ]);
        $data = $query->fetch();
        $query->closeCursor();
        $this->id = $data['id'];
    }

    /**
     * Add task to the database
     */
    public function pushToDB(){
        $db = self::dbConnect();
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(name, description, author, create_date, is_done, project_id) VALUES(:name, :description, :author, NOW(), :is_done, :project_id)');
        $add->execute([
            'name' => $this->name,
            'description' => $this->description ? $this->description : null,
            'author' => $this->author,
            'is_done' => $this->is_done ? 1 : 0,
            'project_id' => $this->project_id
        ]);
        $add->closeCursor();
    }

    // STATIC FUNCTIONS

    /**
    * Get all tasks there are in the database for a specific project
    * @param int $project_id Project id
    * @return Task[] An array of Task
    */
    public static function getAllTasks($project_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE project_id=? ORDER BY create_date DESC');
        $query->execute([$project_id]);
        $tasks = null;
        while($task = $query->fetch()){
            $tasks[] = new Task($task['name'], $task['project_id'], $task['is_done'], $task['create_date'], $task['author'], $task['description']);
        }
        $query->closeCursor();
        return $tasks;
    }

    /**
     * Get a specific a specific tasks by id
     * @param int $id Task id
     * @return Project The specific task
     */
    public static function getTaskById($id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=?');
        $query->execute([$id]);
        $data = $query->fetch();
        $query->closeCursor();
        return new Task($data['name'], $data['project_id'], $data['is_done'], $data['create_date'], $data['author'], $data['description']);
    }

    // SETTERS

    public function setIsDone($is_done){
        $db = self::dbConnect();
        $set = $db->prepare('UPDATE ' . self::TABLE_NAME . ' SET is_done=:value WHERE id=:id');
        $set->execute([
            'id' => $this->getId(),
            'value' => $is_done ? 1 : 0
        ]);
        $set->closeCursor();
    }

    // GETTERS

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getProjectId(){
        return $this->project_id;
    }
    public function getIsDone(){
        return $this->is_done == 1 ? true : false;
    }
    public function getCreateDate(){
        return date("d/m/Y", strtotime($this->create_date));
    }
    public function getAuthor(){
        return $this->author;
    }
    public function getDescription(){
        return $this->description;
    }
}
