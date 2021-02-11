<?php


class Addpixel extends Controller
{
    private $vld;
    private $pixelModel;

    public function __construct()
    {
        if (!isLoggedIn()) redirect('/users/login');
        $this->vld = new Validation();
        $this->pixelModel = $this->model('Pixel');
    }

    public function index($id = null)
    {
            $data = [
                'currentPage' => 'addPixel',
                'currentPixel' => $this->pixelModel->getPixelById($id)
            ];
            $this->view('pixels/addPixel', $data);

    }

    public function add(){

        if ($this->vld->ifRequestIsPostAndSanitize()){
            $data = [
                'coordinate_x' => trim(intval($_POST['x-coordinate'])),
                'coordinate_y' => trim(intval($_POST['y-coordinate'])),
                'color' => trim($_POST['colorSelector']),
                'pixelSize' => trim(intval($_POST['pixelSize'])),
                'userId' => $_SESSION['user_id'],
                'errors' => [
                    'x' => '',
                    'y' => '',
                ],
            ];

            $data['errors']['x'] = $this->vld->validateEmpty($data['coordinate_x'], 'X Coordinate can not be empty');
            $data['errors']['y'] = $this->vld->validateEmpty($data['coordinate_y'], 'Y Coordinate can not be empty');
            $data['errors']['coordinateErr'] = $this->vld->checkIfCoordinatesIsInBound($data['coordinate_x'], $data['coordinate_y'],
                $data['pixelSize']);
            $pixelsArr = $this->pixelModel->getAllPixels();

            if ($data['errors']['x'] === "" && $data['errors']['y'] === "" && $data['errors']['coordinateErr'] === ""){
                $usedCoordinates = [];
                foreach ($pixelsArr as $pixel){
                    for ($x=0; $x<$pixel['size']; $x++){
                        for ($i=0; $i<$pixel['size']; $i++){
                            $usedCoordinates[] = [
                                'x' => $pixel['coordinate_x'] + $x,
                                'y' => $pixel['coordinate_y'] + $i,
                            ];
                        }
                    }
                }
                $data['usedCoordinates'] = $usedCoordinates;

                $newPixelCoordinates = [];
                for ($x=0; $x<$data['pixelSize']; $x++){
                    for ($i=0; $i<$data['pixelSize']; $i++){
                        $newPixelCoordinates[] = [
                            'x' => $data['coordinate_x'] + $x,
                            'y' => $data['coordinate_y'] + $i,
                        ];
                    }
                }
                $data['newPixelCoordinates'] = $newPixelCoordinates;

                $data['errors']['coordinateErr'] = $this->vld->checkIfCoordinateIsEmpty($usedCoordinates, $newPixelCoordinates);

                if ($data['errors']['coordinateErr'] === "") {
                    if ($this->pixelModel->addPixel($data)) {
                        $data['success'] = "Pixeletron added successfully";
                    } else {
                        $data['errors']['coordinateErr'] = "Kazkas sugriuvo su idejimu";
                    }
                    header('Content-Type: application/json');
                    echo json_encode($data);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode($data);
            }



//        $data = [
//            'usedCoordinates' => $usedCoordinates,
//            'x' => intval($_POST['x-coordinate']),
//            'y' => $_POST['y-coordinate'],
//            'newPixelCoordinates' => $newPixelCoordinates
//              'x' => $xCoordinate,
//              'y' => $yCoordinate,
//              'pixelSize' => $pixelSize
//        ];
//
//        header('Content-Type: application/json');
//        echo json_encode($pixelsArr);
        }
    }
}