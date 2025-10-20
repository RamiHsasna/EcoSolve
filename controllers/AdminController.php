<?php
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Opportunity.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function dashboard() {
        $users = $this->adminModel->getUsers();
        $opportunities = $this->adminModel->getOpportunities();
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function updateUser() {
        // Support both form-encoded and JSON payloads
        $input = $_POST;
        if(empty($input)){
            $raw = file_get_contents('php://input');
            $json = json_decode($raw, true);
            if(is_array($json)) $input = $json;
        }
        if (isset($input['user_id'], $input['status'])) {
            $ok = $this->adminModel->updateUserStatus($input['user_id'], $input['status']);
            if(headers_sent()===false){
                header('Content-Type: application/json');
                echo json_encode(['success'=> (bool)$ok]);
                return;
            }
        }
        // fallback redirect for non-ajax
        header("Location: index.php?controller=admin&action=dashboard");
        exit;
    }

    public function updateOpportunity() {
        $input = $_POST;
        if(empty($input)){
            $raw = file_get_contents('php://input');
            $json = json_decode($raw, true);
            if(is_array($json)) $input = $json;
        }
        if (isset($input['event_id'], $input['status'])) {
            $ok = $this->adminModel->updateOpportunityStatus($input['event_id'], $input['status']);
            if(headers_sent()===false){ header('Content-Type: application/json'); echo json_encode(['success'=> (bool)$ok]); return; }
        }
        header("Location: index.php?controller=admin&action=dashboard");
        exit;
    }

    // Delete user (AJAX)
    public function deleteUser(){
        $input = $_POST;
        if(empty($input)){
            $raw = file_get_contents('php://input');
            $json = json_decode($raw, true);
            if(is_array($json)) $input = $json;
        }
        header('Content-Type: application/json');
        if(isset($input['user_id'])){
            $ok = $this->adminModel->deleteUser($input['user_id']);
            echo json_encode(['success'=>(bool)$ok]);
            return;
        }
        echo json_encode(['success'=>false,'message'=>'missing user_id']);
    }

    // Edit user (AJAX)
    public function editUser(){
        $input = $_POST;
        if(empty($input)){
            $raw = file_get_contents('php://input');
            $json = json_decode($raw, true);
            if(is_array($json)) $input = $json;
        }
        header('Content-Type: application/json');
        if(isset($input['user_id'], $input['username'])){
            // optional email
            $ok = $this->adminModel->editUser($input['user_id'], $input['username'], isset($input['email'])?$input['email']:null);
            echo json_encode(['success'=>(bool)$ok]);
            return;
        }
        echo json_encode(['success'=>false,'message'=>'invalid input']);
    }
}
?>
