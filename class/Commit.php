<?php

/**
 * Class to manage commits
 */
class Commit
{
    private $sha;

    function __construct($sha) {
        $this->sha = $sha;
    }

    // STATICS FUNCTIONS

    public static function getAllBranches($username, $project){
        $branches = [];
        $url = "https://api.github.com/repos/" . $username . "/" . $project . "/branches";
        $json = httpRequest($url);
        foreach ($json as $branch) {
            array_push($branches, $branch->name);
        }
        return $branches;
    }

    // GETTERS

    public function getAuthorName(){ return $this->author_name; }
    public function getAuthorMail(){ return $this->author_mail; }
    public function getMessage(){ return $this->message; }
    public function getDate(){ return date("d/m/Y", strtotime($this->date)); }
    public function getSha($size = null){
        return $size ? substr($this->sha, 0, $size) : $this->sha;
    }
}
