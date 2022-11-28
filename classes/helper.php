<?php
    class helper {
    public function isLoggedIn() {
        return isset($_SESSION["username"]);
    }
    
    public function addMessage($message) {
        if (!isset($_SESSION["message"])) {
            $_SESSION["message"] = [];
        }
        array_push($_SESSION["message"], json_encode($message));
    }

    public function getMessages() {
        if (!isset($_SESSION["message"])) {
            return "";
        }
        
        $messages = $_SESSION["message"];

        $_SESSION["message"] = [];
        
        return $messages;
    }
}
