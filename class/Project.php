<?php

/**
 * Class to manage user's projects
 */
class Project extends DatabaseManager
{
    private $name;
    private $description;
    private $remote;

    function __construct(argument)
    {
        $this->name = $name;
        $this->description = $description;
        $this->remote = $remote;
    }

    // GETTERS

    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getRemote(){
        return $this->remote;
    }
}
