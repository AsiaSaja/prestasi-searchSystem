<?php

class Kompetisi_model extends Model {
    protected $table = 'competitions';

    public function getAllCompetitions()
    {
        return $this->getAll();
    }

    public function findCompetitionById($id)
    {
        return $this->find("id = $id");
    }

    public function addCompetition($data)
    {
        $fields = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        return $this->insert($fields, $values);
    }

    public function updateCompetition($id, $data)
    {
        $set = implode(', ', array_map(
            fn($key, $value) => "$key = '$value'",
            array_keys($data),
            array_values($data)
        ));
        return $this->update($set, "id = $id");
    }

    public function deleteCompetition($id)
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