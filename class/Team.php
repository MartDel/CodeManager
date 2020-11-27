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
            $query = $db->prepare('SELECT id, permissions, role FROM ' . self::TABLE_NAME . ' WHERE project_id=:project AND user_id=:user');
            $query->execute([
                'project' => $this->project_id,
                'user' => $this->user_id
            ]);
            $data = $query->fetch();
            $query->closeCursor();
            if(isset($data['id'])){
                $this->id = $data['id'];
                $this->permissions = $data['permissions'];
                $this->role = $data['role'];
            } else throw new Exception();
        } catch (Exception $e) {
            $this->id = null;
            $this->permissions = 0;
            $this->role = null;
        }

    }

    /**
    * Upload the new team user to the database
    */
    public function pushToDB(){
        $db = self::dbConnect();
        $add = $db->prepare('INSERT INTO ' . self::TABLE_NAME . '(project_id, user_id, permissions) VALUES(:project, :user, :permissions)');
        $add->execute([
            'project' => $this->project_id,
            'user' => $this->user_id,
            'permissions' => $this->permissions
        ]);
        $add->closeCursor();
    }

    /**
     * Update a team row from the database
     */
    public function update(){
        $db = self::dbConnect();
        $update = $db->prepare('UPDATE ' . self::TABLE_NAME . ' SET role=:role, permissions=:perm WHERE id=:id');
        $update->execute([
            'role' => $this->role ? $this->role : null,
            'permissions' => $this->permissions,
            'id' => $this->id
        ]);
        $update->closeCursor();
    }

    /**
     * Delete a Team row from the database
     */
    public function delete(){
        $db = self::dbConnect();

        $del = $db->prepare('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=?');
        $del->execute([$this->id]);

        $del = $db->prepare('DELETE FROM ' . Task::TABLE_NAME . ' WHERE author_id=:author AND project_id=:project');
        $del->execute([
            'author' => $this->user_id,
            'project' => $this->project_id
        ]);

        $del->closeCursor();
    }

    /**
     * Check if the Team row exists
     * @return bool if it exists or not
     */
    public function exists(){ return (bool) $this->id; }

    // STATICS FUNCTIONS

    /**
     * Get all users in a team
     * @param int $project_id The team project id
     * @return array All of team users
     */
    public static function getAllUsers($project_id){
        $db = self::dbConnect();
        $r = [];
        $query = $db->prepare('SELECT user_id FROM ' . self::TABLE_NAME . ' WHERE project_id=?');
        $query->execute([$project_id]);
        while ($data = $query->fetch()) {
            array_push($r, User::getUserById($data['user_id']));
        }
        $query->closeCursor();
        return $r;
    }

    // GETTERS

    public function getId(){ return $this->id; }
    public function getProjectId(){ return $this->project_id; }
    public function getUserId(){ return $this->user_id; }
    public function getPermissions(){ return $this->permissions; }
    public function getRole(){ return $this->role; }

    // SETTERS

    public function setPermissions($perm){ $this->permissions = $perm; }
    public function setRole($role){ $this->role = $role; }
}
