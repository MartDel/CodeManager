<?php

/**
 * Class to represent a category
 */
class Category extends DatabaseManager
{
    private $id;
    private $name;
    private $project_id;

    const TABLE_NAME = "categories";

    function __construct($name, $project_id){
        $this->name = $name;
        $this->project_id = $project_id;

        // Get task id
        try {
            $db = self::dbConnect();
            $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE name=:name AND project_id=:project_id');
            $query->execute([
                'name' => $this->name,
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
     * Add category to the database
     */
    public function pushToDB(){
        $db = self::dbConnect();
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(name, project_id) VALUES(:name, :project)');
        $add->execute([
            'name' => $this->name,
            'project' => $this->project_id
        ]);
        $add->closeCursor();
    }

    /**
     * Update a category from the database
     */
    public function update(){
        $db = self::dbConnect();
        $update = $db->prepare('UPDATE ' . self::TABLE_NAME . ' SET name=:name WHERE id=:id');
        $update->execute([
            'name' => $this->name,
            'id' => $this->id
        ]);
        $update->closeCursor();
    }

    // STATIC FUNCTIONS

    /**
    * Get a category by its id
    * @param int $id The category id
    * @return Category Category object
    */
    public static function getCategoryById($id){
        $db = self::dbConnect();
        $query = $db->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=?');
        $query->execute([$id]);
        $data = $query->fetch();
        $query->closeCursor();
        if(isset($data['id'])) return new Category($data['name'], $data['project_id']);
        return null;
    }

    // GETTERS

    public function getId(){ return $this->id; }
    public function getName(){ return $this->name; }
    public function getProjectId(){ return $this->project_id; }

    // SETTERS

    public function setName($name){ $this->name = $name; }
}
