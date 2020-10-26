<?php

class CustomException extends Exception {
    protected $title;
    protected $redirection;
    protected $callback_name;

    public function __construct($title, $message, $redirection, $callback_name = null){
        $this->title = $title;
        $this->redirection = $redirection;
        $this->callback_name = $callback_name;
        parent::__construct($message);
    }

    public function getUrlEncoded(){
        $str = $this->title . '+' . $this->message . '+' . $this->file . '+' . $this->line . '+' . $this->callback_name;
        return urlencode($str);
    }

    public function getRedirection() { return $this->redirection; }
}
