<?php 

class Template_gaji_jabatan_model
{
    private $table = 'template_gaji_jabatan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllTemplate()
    {
        $this->db->query("SELECT tgj.*, jb.jabatan, jb.nama_bidang 
                          FROM template_gaji_jabatan tgj
                          JOIN jabatan_bidang jb ON tgj.id_jabatan_bidang = jb.id");
        return $this->db->resultSet();
    }

    public function getTemplateById($id)
    {
        $this->db->query("SELECT * FROM $this->table WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahTemplate($data)
    {
        $query = "INSERT INTO $this->table (id_jabatan_bidang, gaji_pokok, insentif)
                  VALUES (:id_jabatan_bidang, :gaji_pokok, :insentif)";
        $this->db->query($query);
        $this->db->bind('id_jabatan_bidang', $data['id_jabatan_bidang']);
        $this->db->bind('gaji_pokok', $data['gaji_pokok']);
        $this->db->bind('insentif', $data['insentif']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE $this->table SET id_jabatan_bidang = :id_jabatan_bidang, 
                    gaji_pokok = :gaji_pokok, insentif = :insentif WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('id_jabatan_bidang', $data['id_jabatan_bidang']);
        $this->db->bind('gaji_pokok', $data['gaji_pokok']);
        $this->db->bind('insentif', $data['insentif']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapus($id)
    {
        $this->db->query("DELETE FROM $this->table WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
