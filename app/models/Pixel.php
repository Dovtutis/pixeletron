<?php


class Pixel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllPixels()
    {
        $sql = "SELECT * FROM pixels";

        $this->db->query($sql);
        $result = $this->db->resultArray();
        return $result;
    }

    public function getUserPixels($id)
    {
        $this->db->query('SELECT * FROM pixels WHERE user_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->resultArray();

        if ($this->db->rowCount() > 0){
            return $result;
        }
        return false;
    }

    public function getPixelById($id)
    {
        $this->db->query('SELECT * FROM pixels WHERE pixel_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->resultArray();

        if ($this->db->rowCount() > 0){
            return $result;
        }
        return false;
    }

    public function addPixel($data)
    {
        $this->db->query("INSERT INTO pixels (`user_id`, `coordinate_x`, `coordinate_y`, `color`, `size`)
    VALUES (:user_id, :coordinate_x, :coordinate_y, :color, :size)");
        $this->db->bind(':user_id', $data['userId']);
        $this->db->bind(':coordinate_x', $data['coordinate_x']);
        $this->db->bind(':coordinate_y', $data['coordinate_y']);
        $this->db->bind(':color', $data['color']);
        $this->db->bind(':size', $data['pixelSize']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}

