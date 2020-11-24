<?php

/**
 * Class to represent team users
 */
class Team extends DatabaseManager
{
    private $id;
    private $project_id;
    private $user_id;
    private $permissions;
    private $role;

    const TABLE_NAME = "teams";

    function __construct($project_id, $user_id){
        $this->project_id = $project_id;
        $this->user_id = $user_id;

        // Get row id
        try {
            $db = self::dbConnect();
            $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE project_id=:project AND user_id=:user');
            $query->execute([
                'project' => $this->project_id,
                'user' => $this->user_id
            ]);
            $data = $query->fetch();
            $query->closeCursor();
            $this->id = isset($data['id']) ? $data['id'] : null;
        } catch (Exception $e) {
            $this->id = null;
        }

    }

    /**
    * Upload the new team user to the database
    */
    public function pushToDB(){
        $db = self::dbConnect();
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(project_id, user_id) VALUES(:project, :user)');
        $add->execute([
            'project' => $this->project_id,
            'user' => $this->user_id
        ]);
        $add->closeCursor();
    }

    // GETTERS

    public function getId(){ return $this->id; }
    public function getProjectId(){ return $this->project_id; }
    public function getUserId(){ return $this->user_id; }
    public function getPermissions(){ return $this->permissions; }
    public function getRole(){ return $this->role; }
}
