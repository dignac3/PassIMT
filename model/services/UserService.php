<?php

include dirname(__FILE__).'/../connection.php';

class UserService
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = getConnection();
    }


    public function getUsers()
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users");
        if (!$stmt->execute()) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        $data = $stmt->get_result();

        return $data;
    }

    public function register($mail, $master_password) {
        $stmt = $this->mysqli->prepare("INSERT INTO users (mail, master_password) VALUES (?, ?)");
        $stmt->bind_param('ss', $mail, $master_password);

        if (!($data = $stmt->execute())) {
            echo "Request failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        return $data;
    }
}