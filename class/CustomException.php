<?php

class CustomException extends Exception {
    protected $title;
    protected $redirection;
    protected $callback_name;
    protected $btn;

    public function __construct($title, $message, $redirection, $callback_name = null){
        $this->title = $title;
        $this->redirection = $redirection;
        $this->callback_name = $callback_name;
        $this->btn = null;
        parent::__construct($message);
    }

    public function getUrlEncoded(){
        $title = '&title=' . urlencode($this->title);
        $message = '&message=' . urlencode($this->message);
        $callback_name = $this->callback_name ? '&callback_name=' . urlencode($this->callback_name) : '';
        $btn = $this->btn ? '&btn=' . urlencode($this->btn) : '';
        return '&error' . $title . $message . $callback_name . $btn;
    }

    public function getRedirection() { return 'index.php?action=' . $this->redirection; }

    // SETTERS

    public function setBtn($btn){ $this->btn = $btn; }
}
