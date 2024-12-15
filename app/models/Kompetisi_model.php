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

    public function getCount() {
        $sql = "SELECT COUNT(*) as count FROM competitions";
        $result = $this->db->query($sql);
        return $result ? $result[0]['count'] : 0;
    }
}