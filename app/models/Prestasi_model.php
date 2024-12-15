<?php

class Prestasi_model extends Model {
    protected $table = 'achievements';

    public function getAllAchievements()
    {
        return $this->getAll();
    }

    public function findAchievementById($id)
    {
        return $this->find("id = $id");
    }

    public function addAchievement($data)
    {
        $fields = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        return $this->insert($fields, $values);
    }

    public function updateAchievement($id, $data)
    {
        $set = implode(', ', array_map(
            fn($key, $value) => "$key = '$value'",
            array_keys($data),
            array_values($data)
        ));
        return $this->update($set, "id = $id");
    }

    public function deleteAchievement($id)
    {
        return $this->delete("id = $id");
    }

    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM achievements";
        $result = $this->db->query($sql);
        return $result ? $result[0]['count'] : 0;
    }
}