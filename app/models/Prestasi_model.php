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


    // In Prestasi_model.php

    // In Prestasi_model.php
// Add this to your searchAchievement method in Prestasi_model to debug:
    public function searchAchievement($keyword = '') 
    {
        error_log("=== Search Achievement Called ===");
        error_log("Raw keyword: " . $keyword);
        
        if (empty(trim($keyword))) {
            error_log("Empty keyword, returning empty array");
            return [];
        }
        
        $keyword = trim($keyword);
        
        $sql = "
            SELECT 
                a.id,
                a.achievement,
                s.name AS student_name,
                c.name AS competition_name,
                c.year AS competition_year
            FROM achievements a
            LEFT JOIN students s ON a.student_id = s.id
            LEFT JOIN competitions c ON a.competition_id = c.id
            WHERE 
                LOWER(a.achievement) LIKE LOWER(:keyword) OR
                LOWER(s.name) LIKE LOWER(:keyword) OR
                LOWER(c.name) LIKE LOWER(:keyword) OR
                CAST(c.year AS CHAR) LIKE :keyword
            ORDER BY c.year DESC, s.name ASC
        ";
        
        try {
            $this->db->query($sql);
            $this->db->bind(':keyword', '%' . $keyword . '%');
            
            error_log("Executing query with keyword: %{$keyword}%");
            
            $results = $this->db->resultSet();
            
            error_log("Query results count: " . count($results));
            error_log("Query results: " . print_r($results, true));
            
            return $results;
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return [];
        }
    }

    // Helper method to log searches
    private function logSearch($keyword, $resultCount) 
    {
        $sql = "
            INSERT INTO search_logs (
                keyword, 
                result_count, 
                search_timestamp
            ) VALUES (
                :keyword,
                :count,
                NOW()
            )
        ";
        
        try {
            $this->db->query($sql);
            $this->db->bind(':keyword', $keyword);
            $this->db->bind(':count', $resultCount);
            $this->db->execute();
        } catch (Exception $e) {
            error_log("Failed to log search: " . $e->getMessage());
        }
    }

    // Method to get search suggestions based on popular searches
    public function getSearchSuggestions($partial_keyword) 
    {
        $sql = "
            SELECT DISTINCT keyword 
            FROM search_logs 
            WHERE keyword LIKE :partial 
            GROUP BY keyword 
            ORDER BY COUNT(*) DESC 
            LIMIT 5
        ";
        
        try {
            $this->db->query($sql);
            $this->db->bind(':partial', $partial_keyword . '%');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Suggestion error: " . $e->getMessage());
            return [];
        }
    }
}