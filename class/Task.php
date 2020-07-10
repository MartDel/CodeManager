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

  /**
   * Get stat about project tasks
   * @param String $condition Searched column
   * @param $value Searched value
   * @param int $project_id Project id
   * @return int Number of occurrence of the searched value
   */
  public static function getStat($condition, $value, $project_id){
    $db = self::dbConnect();
    $query = $db->prepare('SELECT id FROM ' . self::TABLE_NAME . ' WHERE ' . $condition . '=? AND project_id=?');
    $query->execute([$value, $project_id]);
    $stat = 0;
    while($task = $query->fetch()){
      $stat++;
    }
    return $stat;
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
