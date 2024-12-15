<?php

class Admin_model extends Model {
    protected $table = 'admins';
    
    public function usernameAlreadyExist($username) {
        return $this->find("username = '$username'");
    }

    public function createAdmin($username, $hashedPassword) {
        return $this->insert('username, password', "'$username', '$hashedPassword'");
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function logAction($action_type, $record_id, $table_name, $description) {
        $query = "INSERT INTO logs (action_type, record_id, table_name, description) 
                  VALUES (:action_type, :record_id, :table_name, :description)";
        $this->db->query($query);
        $this->db->bind(':action_type', $action_type);
        $this->db->bind(':record_id', $record_id);
        $this->db->bind(':table_name', $table_name);
        $this->db->bind(':description', $description);
        $this->db->execute();
    }

    public function getRecentLogs($limit = 5) {
        $query = "SELECT * FROM logs ORDER BY created_at DESC LIMIT :limit";
        $this->db->query($query);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();  // Returns the most recent log entries
    }


}