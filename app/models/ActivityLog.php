<?php


class ActivityLog
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addActivity($data)
    {
        $this->db->query("INSERT INTO activitylog (`pixel_id`, `user_id`, `coordinate_x`, `coordinate_y`, `color`, `size`, `action`)
    VALUES (:pixel_id, :user_id, :coordinate_x, :coordinate_y, :color, :size, :action)");
        $this->db->bind(':pixel_id', $data['pixel_id']);
        $this->db->bind(':user_id', $data['userId']);
        $this->db->bind(':coordinate_x', $data['coordinate_x']);
        $this->db->bind(':coordinate_y', $data['coordinate_y']);
        $this->db->bind(':color', $data['color']);
        $this->db->bind(':size', $data['pixelSize']);
        $this->db->bind(':action', $data['action']);

        $this->db->execute();
    }

    public function getAllActivity($id)
    {
        $this->db->query('SELECT * FROM activitylog WHERE user_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->resultArray();

        if ($this->db->rowCount() > 0){
            return $result;
        }
        return false;
    }
}