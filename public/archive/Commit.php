<?php

/**
 * Class to manage commits
 */
class Commit
{
    private $sha;
    private $author_name;
    private $author_mail;
    private $message;
    private $date;

    function __construct($json) {
        $commit = $json->commit;
        $author = $commit->author;

        $this->sha = $json->sha;
        $this->author_name = $author->name;
        $this->author_mail = $author->email;
        $this->message = $commit->message;
        $this->date = $author->date;
    }

    // STATIC FUNCTION

    public static function getAllCommits($username, $project){
        $opts = array(
    	  'http'=>array(
    	    'method'=>"GET",
    	    'header'=>"User-Agent: martdel\r\n"
    	  )
    	);
    	$context = stream_context_create($opts);

    	$url = "https://api.github.com/repos/" . $username . "/" . $project . "/commits";
      	$raw = file_get_contents($url, false, $context);
      	$json = json_decode($raw);

        $commits = [];
        foreach ($json as $commit) {
            $c = new Commit($commit);
            array_push($commits, $c);
        }
        return $commits;
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
