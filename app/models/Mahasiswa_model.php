<?php

class Mahasiswa_model extends Model {
    protected $table = 'students';

    public function getAllStudents()
    {
        return $this->getAll();
    }

    public function findStudentById($id)
    {
        return $this->find("id = $id");
    }

    public function addStudent($data)
    {
        $fields = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        return $this->insert($fields, $values);
    }

    public function updateStudent($id, $data)
    {
        $set = implode(', ', array_map(
            fn($key, $value) => "$key = '$value'",
            array_keys($data),
            array_values($data)
        ));
        return $this->update($set, "id = $id");
    }

    public function deleteStudent($id)
    {
        return $this->delete("id = $id");
    }

    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM students";
        $result = $this->db->query($sql);
        return $result ? $result[0]['count'] : 0;
    }

}