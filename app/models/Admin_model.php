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


}