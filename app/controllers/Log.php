<?php

class Log extends Controller
{
    // This method will fetch the recent logs and send them to the view
    public function index()
    {
        // Load the LogModel
        $logModel = $this->model('LogModel');

        // Fetch the recent 5 logs
        $recentLogs = $logModel->getRecentLogs();

        // Pass the logs to the view
        $data = [
            'recentLogs' => $recentLogs,
        ];

        // Render the admin dashboard view with the logs data
        $this->view('admin/dashboard', $data);
    }

    // This method can be used to log an action
    public function logAction($action_type, $record_id, $table_name, $description)
    {
        // Load the LogModel
        $logModel = $this->model('LogModel');

        // Log the action
        $logModel->logAction($action_type, $record_id, $table_name, $description);
    }
}
