<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Searches for the user in the database by email. Handles SQL query, binds parameters and executes it.
     *
     * @param [type] $email
     * @return void
     */
    public function findUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->singleRow();
        if ($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Creates user in the database. Handles SQL query, binds parameters and executes it.
     *
     * @param [type] $data
     * @return void
     */
    public function register($data)
    {
        $this->db->query("INSERT INTO users (`firstname`, `lastname`, `email`, `password`) VALUES (:firstname, :lastname, :email, :password)");
        $this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Tries to login the user. Handles SQL query, binds parameters and executes it.
     *
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function login($email, $password)
    {
        $this->db->query("SELECT * FROM users WHERE `email` = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->singleRow();

        if ($row){
            $hashedPassword = $row->password;
        }else{
            return false;
        }

        if (password_verify($password, $hashedPassword)){
            return $row;
        }else {
            return false;
        }
    }

    /**
     * Gets specified user by given id. Handles SQL query, binds parameters and executes it.
     *
     * @param [type] $id
     * @return void
     */
    public function getUserById($id)
    {
        $this->db->query("SELECT name, email FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }
}