<?php
session_start();

spl_autoload_register(function ($classname) {
    include "classes/$classname.php";
});

$helper = new helper();

$command = "";
if (isset($_GET["command"])) {
    $command = $_GET["command"];
}

if (!$helper->isLoggedIn()) {
    if ($command === "register" or $command === "login") {
    } else {
        $command = "register";
    }
} else {
}

$concertApp = new controller($command);
$concertApp->run();
