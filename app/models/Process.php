<?php


class Process{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    //Get all users
    public function getUsers(){
        //Prepared statement
        $this->db->query("SELECT * FROM user_data WHERE deleted = 0");

        //Execute function and get all rows that satisfy statement
        $result = $this->db->resultSet();
        return $result;
    }

    // Register user
    public function register($data) {
        //Prepare statement
        $this->db->query('INSERT INTO user_data (name, address, email, password) VALUES(:name, :address, :email, :password)');

        //Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

     //Find if user with given email exists. Email is passed in by the Controller.
     public function findUserByEmail($email) {
        //Prepare statement
        $this->db->query("SELECT * FROM user_data WHERE email = :email AND deleted = 0");

        //Bind values
        $this->db->bind(':email', $email);
        
        //Execute function
        $this->db->execute();

        //Check if email is already registered
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Login
    public function login($email, $password) {
        $this->db->query('SELECT * FROM user_data WHERE email = :email');

        //Bind value
        $this->db->bind(':email', $email);

        // Get first user that satisfies statement
        $row = $this->db->single();

        // $hashedPassword = $row->password;

        // Check if provided and registered passwords match
        // if (password_verify($password, $hashedPassword)) {
        //     return $row;
        // } else {
        //     return false;
        // }
        return $row;
    }

    // Update user info
    public function updateUser ($data){
        $this->db->query('UPDATE user_data SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id');

        //Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', $data['firstName']);
        $this->db->bind(':last_name', $data['lastName']);
        $this->db->bind(':email', $data['email']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete user
    public function deleteUser ($id){
        $this->db->query('UPDATE user_data SET deleted = 1 WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}