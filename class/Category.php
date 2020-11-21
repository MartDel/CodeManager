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
}
