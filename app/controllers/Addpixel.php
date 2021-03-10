<?php


class Addpixel extends Controller
{
    private $vld;
    private $pixelModel;
    private $activityModel;

    public function __construct()
    {
        if (!isLoggedIn()) redirect('/users/login');
        $this->vld = new Validation();
        $this->pixelModel = $this->model('Pixel');
        $this->activityModel = $this->model('ActivityLog');
    }

    public function index($id = null)
    {
            $data = [
                'currentPage' => 'addPixel',
                'currentPixel' => $this->pixelModel->getPixelById($id),
                'currentParam' => ''
            ];

            if ($id !== null){
                $data['currentParam'] = 'edit';
            }
            $this->view('pixels/addPixel', $data);

    }

    /**
     * Handles addition and validation of new pixel.
     *
     * @param [type] $id
     * @return void
     */
    public function add($id = null){

        $idFromPost = $id;

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

            if ($idFromPost !== null){
                $pixelsArr = $this->pixelModel->getAllPixels();
                $pixelsArr = array_filter($pixelsArr, function($pixel) use($idFromPost){
                    return $pixel['pixel_id'] !== $idFromPost;
                });
            }else{
                $pixelsArr = $this->pixelModel->getAllPixels();
            }

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
                    if ($idFromPost !== null){
                        $data['pixel_id'] = $idFromPost;
                        if ($this->pixelModel->editPixel($data)) {
                            $data['action'] = "Edited";
                            $this->activityModel->addActivity($data);
                            $data['success'] = "Pixeletron edited successfully";
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        } else {
                            $data['errors']['coordinateErr'] = "Kazkas sugriuvo su editinimu";
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }

                    }else{
                        if ($this->pixelModel->addPixel($data)) {
                            $latestPixel = $this->pixelModel->getLatestPixel();
                            $data['pixel_id'] = $latestPixel[0]['pixel_id'];
                            $data['action'] = "Created";
                            $this->activityModel->addActivity($data);
                            $data['success'] = "Pixeletron added successfully";
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        } else {
                            $data['errors']['coordinateErr'] = "Kazkas sugriuvo su idejimu";
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }

    /**
     * Handles the delete of existing pixels
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        $pixelForDelete = $this->pixelModel->getPixelById($id);

        if ($this->pixelModel->deletePixel(intval($id))) {
            $data = [
                'coordinate_x' => $pixelForDelete[0]['coordinate_x'],
                'coordinate_y' => $pixelForDelete[0]['coordinate_y'],
                'color' => $pixelForDelete[0]['color'],
                'pixelSize' => $pixelForDelete[0]['size'],
                'userId' => $_SESSION['user_id'],
                'pixel_id' => $id,
                'action' => 'Deleted',
                'deleteResponse' => "Pixeletron deleted successfully"
            ];
            $this->activityModel->addActivity($data);
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['deleteResponse'] = "Delete was unsuccessful";
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
}