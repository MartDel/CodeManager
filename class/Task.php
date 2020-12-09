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
    private $author_id;
    private $description;
    private $category_id;

    const TABLE_NAME = "tasks";

    function __construct($name, $project_id, $is_done, $create_date, $author_id, $description, $category_id = null){
        $this->name = $name;
        $this->project_id = $project_id;
        $this->is_done = $is_done;
        $this->create_date = $create_date;
        $this->author_id = $author_id;
        $this->description = $description;
        $this->category_id = $category_id;

        // Get task id
        try {
            $db = self::dbConnect();
            $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE name=:name AND author_id=:author AND project_id=:project_id');
            $query->execute([
                'name' => $this->name,
                'author' => $this->author_id,
                'project_id' => $this->project_id
            ]);
            $data = $query->fetch();
            $query->closeCursor();
            $this->id = isset($data['id']) ? $data['id'] : null;
        } catch (Exception $e) {
            $this->id = null;
        }
    }

    /**
     * Add task to the database
     */
    public function pushToDB(){
        $db = self::dbConnect();
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(name, description, category_id, author_id, create_date, is_done, project_id) VALUES(:name, :description, :category, :author, NOW(), :is_done, :project)');
        $add->execute([
            'name' => $this->name,
            'description' => $this->description ? $this->description : null,
            'category' => $this->category_id ? $this->category_id : null,
            'author' => $this->author_id,
            'is_done' => $this->is_done ? 1 : 0,
            'project' => $this->project_id
        ]);
        $add->closeCursor();
    }

    /**
     * Delete a task from the database
     */
    public function delete(){
        $db = self::dbConnect();
        $del = $db->prepare('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=?');
        $del->execute([$this->id]);
        $del->closeCursor();
    }

    /**
     * Update a task from the database
     */
    public function update(){
        $db = self::dbConnect();
        $update = $db->prepare('UPDATE ' . self::TABLE_NAME . ' SET name=:name, description=:description, category_id=:category, is_done=:is_done WHERE id=:id');
        $update->execute([
            'name' => $this->name,
            'description' => $this->description ? $this->description : null,
            'category' => $this->category_id ? $this->category_id : null,
            'is_done' => $this->is_done ? 1 : 0,
            'id' => $this->id
        ]);
        $update->closeCursor();
    }

    // STATIC FUNCTIONS

    /**
    * Get all tasks there are in the database for a specific project
    * @param int $project_id Project id
    * @return Task[] An array of Task
    */
    public static function getAllTasks($project_id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE project_id=? ORDER BY category_id DESC, create_date DESC');
        $query->execute([$project_id]);
        $tasks = null;
        while($task = $query->fetch()){
            $tasks[] = new Task($task['name'], $task['project_id'], $task['is_done'], $task['create_date'], $task['author_id'], $task['description'], $task['category_id']);
        }
        $query->closeCursor();
        return $tasks;
    }

    /**
     * Get a specific a specific tasks by id
     * @param int $id Task id
     * @return Project The specific task
     */
    public static function getTaskById($id, $project){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=? AND project_id=?');
        $query->execute([$id, $project]);
        $data = $query->fetch();
        $query->closeCursor();
        return isset($data['id']) ? new Task($data['name'], $data['project_id'], $data['is_done'], $data['create_date'], $data['author_id'], $data['description'], $data['category_id']) : null;
    }

    // GETTERS

    public function getId(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function getProjectId(){ return $this->project_id; }
    public function getIsDone(){ return $this->is_done == 1 ? true : false; }
    public function getCreateDate(){ return date("d/m/Y", strtotime($this->create_date)); }
    public function getAuthorId(){ return $this->author_id; }
    public function getDescription(){ return $this->description; }
    public function getCategoryId(){ return $this->category_id; }

    public function getAuthor(){
        $author = User::getUserById($this->author_id);
        if($author) return $author->getPseudo();
        return null;
    }

    public function getCategory(){
        $category = Category::getCategoryById($this->category_id);
        if($category) return $category->getName();
        return null;
    }

    // SETTERS

    public function setName($name){ $this->name = $name; }
    public function setDescription($desc){ $this->description = $desc; }
    public function setCategoryID($id){ $this->category_id = $id; }
    public function setIsDone($is_done){ $this->is_done = $is_done; }
}
