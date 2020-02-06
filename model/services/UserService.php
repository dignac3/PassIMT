<?php

class UserService
{
    protected $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
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