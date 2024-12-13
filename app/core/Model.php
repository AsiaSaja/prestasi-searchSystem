<?php

class Model {
    protected $db;
    protected $table;
    protected $id = 'id';

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll($where = null)
    {
        $query = 'SELECT * FROM ' . $this->table;
        if($where) {
            $query .= ' WHERE ' . $where;
        }
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function get($attributes = '*', $where = null)
    {
        $query = 'SELECT ' . $attributes . ' FROM ' . $this->table;
        if($where) {
            $query .= ' WHERE ' . $where;
        }
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function find($where)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $where;
        $this->db->query($query);
        return $this->db->single();
    }

    public function delete($where)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        $this->db->query($query);
        return $this->db->execute();
    }

    public function insert($fields, $values)
    {
        $query = 'INSERT INTO ' . $this->table . ' (' . $fields . ') VALUES (' . $values . ')';
        $this->db->query($query);
        return $this->db->execute();
    }

    public function update($set, $where)
    {
        $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $where;
        $this->db->query($query);
        return $this->db->execute();
    }


}