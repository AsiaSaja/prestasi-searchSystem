<?php

class LogModel extends Model
{
    protected $table = 'logs'; // Define the table name

    public function logAction($action_type, $record_id, $table_name, $description)
    {
        $fields = 'action_type, record_id, table_name, description, created_at';
        $values = ':action_type, :record_id, :table_name, :description, NOW()';
        $this->db->query("INSERT INTO {$this->table} ({$fields}) VALUES ({$values})");
        $this->db->bind(':action_type', $action_type);
        $this->db->bind(':record_id', $record_id);
        $this->db->bind(':table_name', $table_name);
        $this->db->bind(':description', $description);

        return $this->db->execute();
    }

    public function getRecentLogs($limit = 5)
    {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }
}
