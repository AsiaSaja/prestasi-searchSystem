<?php

class Mahasiswa_model {
    private $table = 'mahasiswa';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Ambil semua mahasiswa
    public function getAllMahasiswa()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    // Ambil mahasiswa berdasarkan ID
    public function getMahasiswaById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // Ambil mahasiswa berdasarkan NIM
    public function getMahasiswaByNim($nim)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE nim = :nim');
        $this->db->bind('nim', $nim);
        return $this->db->single();
    }

    // Tambah data mahasiswa
    public function tambahDataMahasiswa($data)
    {
        if ($this->isNimExist($data['nim'])) {
            return false; // Jika NIM sudah ada
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO mahasiswa (nama, email, password, nim, jurusan)
            VALUES (:nama, :email, :password, :nim, :jurusan)";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('nim', $data['nim']);
        $this->db->bind('jurusan', $data['jurusan']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // Edit data mahasiswa
    public function editDataMahasiswa($data)
    {
        // Ambil data lama berdasarkan ID
        $oldData = $this->getMahasiswaById($data['id']);

        // Jika password tidak diubah, gunakan password lama
        $hashedPassword = $data['password'] === $oldData['password']
            ? $oldData['password'] // Password tidak berubah
            : password_hash($data['password'], PASSWORD_DEFAULT); // Hash password baru

        $query = "UPDATE mahasiswa
            SET nama = :nama, email = :email, password = :password, nim = :nim, jurusan = :jurusan 
            WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('nim', $data['nim']);
        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // Hapus data mahasiswa
    public function hapusDataMahasiswa($id)
    {
        $query = "DELETE FROM mahasiswa WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // Cek apakah NIM sudah ada
    public function isNimExist($nim)
    {
        $this->db->query('SELECT nim FROM ' . $this->table . ' WHERE nim = :nim');
        $this->db->bind('nim', $nim);
        return $this->db->single();
    }

    // Set reset token untuk reset password
    public function setResetToken($email, $token)
    {
        $query = "UPDATE mahasiswa SET reset_token = :token WHERE email = :email";

        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->bind('token', $token);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // Ambil user berdasarkan token reset
    public function getUserByToken($token)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE reset_token = :token");
        $this->db->bind('token', $token);

        return $this->db->single();
    }

    // Update password
    public function updatePassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE mahasiswa SET password = :password, reset_token = NULL WHERE email = :email";

        $this->db->query($query);
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('email', $email);

        $this->db->execute();

        return $this->db->rowCount();
    }
}
