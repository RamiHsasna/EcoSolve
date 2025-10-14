<?php
require_once 'models/Admin.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function dashboard() {
        $users = $this->adminModel->getUsers();
        $opportunities = $this->adminModel->getOpportunities();
        include 'views/admin/dashboard.php';
    }

    public function updateUser() {
        if (isset($_POST['user_id'], $_POST['status'])) {
            $this->adminModel->updateUserStatus($_POST['user_id'], $_POST['status']);
        }
        header("Location: index.php?controller=admin&action=dashboard");
    }

    public function updateOpportunity() {
        if (isset($_POST['event_id'], $_POST['status'])) {
            $this->adminModel->updateOpportunityStatus($_POST['event_id'], $_POST['status']);
        }
        header("Location: index.php?controller=admin&action=dashboard");
    }
}
?>
