<?php

class InformationMessage {
    private $title;
    private $message;
    private $redirection;
    private $callback_name;
    private $btn = null;
    private $arg = null;

    public function __construct($title, $message, $redirection, $callback_name = null){
        $this->title = $title;
        $this->message = $message;
        $this->redirection = $redirection;
        $this->callback_name = $callback_name;
    }

    public function redirect(){ header('Location: ' . $this->getRedirection() . $this->getUrlEncoded()); }

    // GETTERS

    public function getUrlEncoded(){
        $title = '&title=' . urlencode($this->title);
        $message = '&message=' . urlencode($this->message);
        $callback_name = $this->callback_name ? '&callback_name=' . urlencode($this->callback_name) : '';
        $btn = $this->btn ? '&btn=' . urlencode($this->btn) : '';
        $arg = $this->arg ? '&arg=' . urlencode($this->arg) : '';
        return '&info' . $title . $message . $callback_name . $btn . $arg;
    }

    public function getRedirection() { return $this->redirection; }

    // SETTERS

    public function setBtn($btn){ $this->btn = $btn; }
    public function setArg($arg){ $this->arg = $arg; }
}
