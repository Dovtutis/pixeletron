<?php

class Activity extends Controller
{
    private $activityModel;

    public function __construct()
    {
        if (!isLoggedIn()) redirect('/users/login');
        $this->activityModel = $this->model('ActivityLog');
    }

    public function index()
    {
        $id = $_SESSION['user_id'];
        $data['activityLog'] = $this->activityModel->getAllActivity($id);
        $data['currentPage'] = 'activityLog';
        $this->view('users/activityLog', $data);
    }
}