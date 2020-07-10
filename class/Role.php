<?php

/**
 * Class to represent a role
 */
class Role extends DatabaseManager
{
  private $permission;
  private $name;
  private $project;

  function __construct($name, $permission, $project)
  {
    $this->name = $name;
    $this->permission = $permission;
    $this->project = $project;
  }

  // GETTERS

  public function getName(){
    return $this->name;
  }
  public function getPermission(){
    return $this->permission;
  }
  public function getProject(){
    return $this->project;
  }
}
