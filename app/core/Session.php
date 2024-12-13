<?php

class Session {
    public function __construct() {
        session_start(); // Start the session
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value; // Set a session variable
    }

    public function get($key) {
        return $_SESSION[$key] ?? null; // Get a session variable
    }

    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]); // Remove a session variable
        }
    }

    public function destroy() {
        session_destroy(); // Destroy the entire session
    }

    public function regenerate() {
        session_regenerate_id(true); // Regenerate the session ID
    }

    public function isLoggedIn() {
        return isset($_SESSION['admin_id']); // Check if a user is logged in
    }
}