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
        $this->db->query("SELECT 
                        user.id, 
                        user.username, 
                        user.role, 
                        pegawai.nama, 
                        pegawai.email
                      FROM user
                      LEFT JOIN pegawai ON user.id_pegawai = pegawai.id");
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

    // public function updateUser($username, $data)
    // {
    //     $query = "UPDATE user SET username = :username, password = :password, nama = :nama, email = :email WHERE id = :id";
    //     $this->db->query($query);
    //     $this->db->bind('username', $username);
    //     $this->db->bind('password', $data['password']);
    //     $this->db->bind('nama', $data['nama']);
    //     $this->db->bind('email', $data['email']);
    //     $this->db->bind('id', $data['id']);

    //     $this->db->execute();

    //     return $this->db->rowCount();
    // }

    public function updateUser($id, $data)
    {
        // Update password hanya jika diberikan
        $setPassword = '';
        if (!empty($data['password'])) {
            $setPassword = ", password = :password";
        }

        $query = "UPDATE {$this->table} 
                  SET id_pegawai = :id_pegawai, username = :username, role = :role{$setPassword}
                  WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('id', $id);

        if (!empty($data['password'])) {
            $this->db->bind('password', $data['password']);
        }

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

    public function hapusDataUser($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahDataUser($data)
    {
        $query = "INSERT INTO user (username, password, role, id_pegawai) VALUES (:username, :password, :role, :id_pegawai)";
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('id_pegawai', $data['id_pegawai']);
        $this->db->bind('role', $data['role']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cekUsernameDuplikat($username)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE username = :username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $result = $this->db->single();
        return $result['total'] > 0; // Mengembalikan true jika ada duplikat
    }

    public function cekIdPegawaiDuplikat($id_pegawai, $excludeUserId = null)
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE id_pegawai = :id_pegawai";

        if ($excludeUserId !== null) {
            $query .= " AND id != :exclude_id";
        }

        $this->db->query($query);
        $this->db->bind('id_pegawai', $id_pegawai);

        if ($excludeUserId !== null) {
            $this->db->bind('exclude_id', $excludeUserId);
        }

        $result = $this->db->single();
        return $result['total'] > 0; // true jika id_pegawai sudah digunakan
    }
}
