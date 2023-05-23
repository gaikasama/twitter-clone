<?php


class User{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUser($user_id){
        $this->db->query("SELECT user_data.id, user_data.username, user_profile.nickname, user_profile.description FROM user_data
        LEFT JOIN user_profile on user_data.id = user_profile.user_id WHERE user_data.id = :id");

        $this->db->bind(':id', $user_id);

        $result = $this->db->single();
        return $result;

    }

    public function getOriginUserByTweetId($tweet_id)
    {
        $this->db->query('SELECT user_data.id, user_data.username, user_profile.nickname, user_profile.description FROM tweet 
        LEFT JOIN user_data ON user_data.id = tweet.user_id 
        LEFT JOIN user_profile on user_data.id = user_profile.user_id WHERE tweet.id = :tweet_id;');

        $this->db->bind(':tweet_id', $tweet_id);

        $result = $this->db->single();
        return $result;
    }
    
    //Find if user with given email exists. Email is passed in by the Controller.
    public function findUserByEmail($email) {
        //Prepare statement
        $this->db->query("SELECT * FROM user_data WHERE email = :email AND delete_flg = 0");

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

    public function register($data){
        //Prepare statement
        $this->db->query('INSERT INTO user_data (username,  email, password) VALUES(:username, :email, :password);
        INSERT INTO user_profile (user_id, nickname) VALUES (LAST_INSERT_ID(), :nickname);');

        //Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':nickname', $data['nickname']);

        //Execute function
        if ($this->db->execute()) {
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
        $hashedPassword = $row->password;

        // Check if provided and registered passwords match
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    public function follow($follower_id, $user_id){
        $this->db->query("INSERT INTO user_users (follower_id, user_id) VALUES(:follower_id, :user_id);");
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':user_id', $user_id);
        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function unfollow($follower_id, $user_id){
        $this->db->query("DELETE FROM user_users WHERE follower_id = :follower_id AND user_id = :user_id");
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':user_id', $user_id);
        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Check if user follows or not another user
    public function userFollow($follower_id, $user_id){
        $this->db->query("SELECT * FROM user_users WHERE follower_id = :follower_id AND user_id = :user_id");
        $this->db->bind(':follower_id', $follower_id);
        $this->db->bind(':user_id', $user_id);

        //Execute function
        $this->db->execute();

        //Check if email is already registered
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserProfile($data){
        $this->db->query("UPDATE user_profile SET description = :description, nickname = :nickname, picture_id = :picture_id, background_id = :background_id WHERE user_id = :user_id ");

        $this->db->bind(':description', $data['description']);
        $this->db->bind(':nickname', $data['nickname']);
        $this->db->bind(':picture_id', $data['picture_id']);
        $this->db->bind(':background_id', $data['background_id']);
        $this->db->bind(':user_id', $data['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsersBySubstring($mention){

        $this->db->query('SELECT username FROM user_data WHERE username LIKE :substr LIMIT 5;');

        $this->db->bind(':substr', '%'.$mention.'%');

        $result = $this->db->values();
        return $result;
    }

    public function getUserIdByUserName($username){
        $this->db->query("SELECT id FROM user_data WHERE username = :username");
        $this->db->bind(':username', $username);
        $result = $this->db->single();
        return $result;


    }

}