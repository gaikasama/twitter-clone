<?php


class Image{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }


    // Post tweet
    public function saveTweetPicture($data){
        //Prepare statement
        $this->db->query('INSERT INTO picture (picture_name, path) VALUES (:picture_name, :path);');

        //Bind values
        $this->db->bind(':picture_name', $data['picture_name']);
        $this->db->bind(':path', $data['path']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPictureIdByName($name){
        $this->db->query("SELECT id FROM picture WHERE picture_name = :picture_name");
        $this->db->bind(':picture_name', $name);
        $result = $this->db->singleValue();
        return $result;
    }

    public function savePictureAndTweet($tweet_id, $picture_id){
        //Prepare statement
        $this->db->query('INSERT INTO tweet_pictures (tweet_id, picture_id) VALUES (:tweet_id, :picture_id);');

        //Bind values
        $this->db->bind(':tweet_id', $tweet_id);
        $this->db->bind(':picture_id', $picture_id);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTweetPicturesByTweetId($tweet_id){
        $this->db->query("SELECT picture_id FROM tweet_pictures WHERE tweet_id = :tweet_id");
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->resultSet();
        return $result;
    }

    public function getPictureByPictureId($picture_id){
        $this->db->query("SELECT * FROM picture WHERE id = :id");
        $this->db->bind(':id', $picture_id);
        $result = $this->db->single();
        return $result;
    }

    public function getAvatarByUserId($user_id){
        $this->db->query("SELECT * FROM picture LEFT JOIN user_profile ON picture.id = user_profile.picture_id WHERE user_profile.user_id = :user_id;");
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result; 
    }

    public function getBackgroundByUserId($user_id){
        $this->db->query("SELECT * FROM picture LEFT JOIN user_profile ON picture.id = user_profile.background_id WHERE user_profile.user_id = :user_id;");
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result; 
    }
}