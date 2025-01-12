<?php

class User_model
{
    private $table = 'user';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllUser()
    {
        $this->db->query("SELECT * FROM " . $this->table);
        return $this->db->resultSet();
    }

    public function getUserByUsername($username)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE username=:username");
        $this->db->bind('username', $username);
        $result = $this->db->single();
        return $result;
    }

    public function getUserByEmail($email)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE email=:email");
        $this->db->bind('email', $email);
        return $this->db->single();
    }
    public function getUserByUsernameOrEmail($input)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE username=:input OR email=:input");
        $this->db->bind('input', $input);
        return $this->db->single();
    }
}
