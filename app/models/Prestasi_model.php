<?php

class Prestasi_model extends Model {
    protected $table = 'achievements';

    public function getAllAchievements()
    {
        $sql = "
            SELECT achievements.id, achievements.student_id, achievements.competition_id, achievements.achievement, 
                   students.name AS student_name, competitions.name AS competition_name
            FROM achievements
            LEFT JOIN students ON achievements.student_id = students.id
            LEFT JOIN competitions ON achievements.competition_id = competitions.id
        ";

        // Use the executeQuery method from Model class to fetch results
        $result = $this->executeQuery($sql);

        // var_dump($result);

        return $result;
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

    public function getCount()
    {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table;
        
        // Execute the query
        $this->db->query($sql);
        
        // Fetch the result (single row)
        $result = $this->db->single(); // single() returns the first row as an associative array

        // Check if the result is valid and return the count, otherwise return 0
        return $result ? $result['count'] : 0;
    }

}