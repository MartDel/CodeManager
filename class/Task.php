<?php

/**
 * Class to represent a task
 */
class Task extends DatabaseManager
{
    private $name;
    private $project_id;
    private $is_done;
    private $create_date;
    private $author;

    private $description;

    const TABLE_NAME = "tasks";

    function __construct($name, $project_id, $is_done, $create_date, $author, $description = null)
    {
        $this->name = $name;
        $this->project_id = $project_id;
        $this->is_done = $is_done;
        $this->create_date = $create_date;
        $this->author = $author;
        $this->description = $description;
    }

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
    }

    /**
    * Get all tasks there are in the database for a specific project
    * @param int $project_id Project id
    * @return Task[] An array of Task
    */
    public static function getAllTasks($project_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE project_id=?');
        $query->execute([$project_id]);
        $tasks = null;
        while($task = $query->fetch()){
            $tasks[] = new Task($task['name'], $task['project_id'], $task['is_done'], $task['create_date'], $task['author'], $task['description']);
        }
        return $tasks;
    }

    // GETTERS

    public function getName(){
        return $this->name;
    }
    public function getProjectId(){
        return $this->project_id;
    }
    public function getIsDone(){
        return $this->is_done;
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
