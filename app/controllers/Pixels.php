<?php

class Pixels extends Controller
{
    private $pixelModel;
    private $currentPage;


    public function __construct(){
        $this->pixelModel = $this->model('Pixel');
    }

    public function index($var = null)
    {
        if ($var === 'all'){
            $data = [
                'title' => 'Welcome to ' . SITENANE,
                'currentPage' => 'home',
                'currentMethod' => 'showAllPixels'
            ];
            $this->currentPage = 'home';
            $this->view('pixels/index', $data);
        }

        if ($var === 'user'){
            $data = [
                'title' => 'Welcome to ' . SITENANE,
                'currentPage' => 'myPixels',
                'currentMethod' => 'showUserPixels'
            ];
            $this->currentPage = 'userPixels';
            $this->view('pixels/index', $data);
        }

    }

    public function showAllPixels()
    {
        $data = [
            'allPixels' => $this->pixelModel->getAllPixels(),
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function showUserPixels()
    {
        $userId = $_SESSION['user_id'];
        $data = [
            'allPixels' => $this->pixelModel->getUserPixels($userId),
        ];
        header('Content-Type: application/json');
        echo json_encode($data);


    }
}