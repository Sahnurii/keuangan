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

    public function updateUser($username, $data)
    {
        $query = "UPDATE user SET username = :username, password = :password, nama = :nama, email = :email WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('password', $data['password']);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id=:id");
        $this->db->bind('id', $id);
        $result = $this->db->single();
        return $result;
    }
}
