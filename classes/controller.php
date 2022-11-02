<?php
//  Function variables are accessible by included templates

class controller
{
    private $command;

    private $db;
    private $helper;

    public function __construct($command)
    {
        $this->command = $command;

        $this->db = new database();
        $this->helper = new helper();
    }

    public function run()
    {
        switch ($this->command) {
            case "login":
                $this->login();
                break;
            case "register":
                $this->register();
                break;
            case "logout":
                session_destroy();
                $this->login();
                break;
            case "home":
                $this->home();
                break;
            default:
                $this->login();
                break;
        }
    }

    // To login the user.
    // If a match is found for the given credentials in the database, the user lands on the home page.
    // Else, the user is prompted to try again.
    private function login()
    {
        if (isset($_POST["username"])) {
            $data = $this->db->query("select * from user where username = ?;", "s", $_POST["username"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $_SESSION["username"] = $data[0]["username"];
                    $_SESSION["userid"] = $data[0]["userid"];

                    header("Location: ?command=home");
                } else {
                    $error_msg = "Wrong password";
                }
            }
        }
        include("templates/login.php");
    }

    // To register new users.
    // Prompts for the user's name, email, and a password, and adds them to the database.
    // User then lands on the home page.
    private function register() {
        if (isset($_POST["username"])) {
            $email = $_POST["username"];
            $insert = $this->db->query(
                "insert into user (username, password) values (?, ?);",
                "ss",
                $_POST["username"],
                password_hash($_POST["password"], PASSWORD_DEFAULT)
            );
            if ($insert === false) {
                $error_msg = "Error inserting user";
            }
            if ($insert === true) {
                $data = $this->db->query("select * from user where username = ?;", "s", $_POST["username"]);
                $_SESSION["username"] = $data[0]["username"];
                $_SESSION["userid"] = $data[0]["userid"];

                header("Location: ?command=home");
            }
        }
        include("templates/register.php");
    }

    // Loads and sorts the posts by newest, and displays them as a home page.
    private function home()
    {
        

        include("templates/home.php");
    }
}