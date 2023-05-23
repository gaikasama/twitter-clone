<?php


class Hashtag{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getHashtagsBySubstring($substr){
        $this->db->query('SELECT content FROM hashtag WHERE content LIKE :substr LIMIT 5;');

        $this->db->bind(':substr', '%'.$substr.'%');

        $result = $this->db->values();
        return $result;
    }

    public function postHashtag($hashtag){
        $this->db->query("INSERT INTO hashtag (content) VALUES (:hashtag)");
        $this->db->bind(':hashtag', $hashtag);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function postTweetHashtag($hashtag_id, $tweet_id){
        $this->db->query("INSERT INTO hashtag_tweets (hashtag_id, tweet_id) VALUES (:hashtag_id, :tweet_id)");

        $this->db->bind(':hashtag_id', $hashtag_id);
        $this->db->bind(':tweet_id', $tweet_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getHashtagIdByHashtag($hashtag){
            $this->db->query("SELECT id FROM hashtag WHERE content = :hashtag");
            $this->db->bind(':hashtag', $hashtag);
            $result = $this->db->singleValue();
            if($result){
                return $result;

            }else{
                return false;
            }
    }

    // Search for hashtags that contain substring of a provided hashtag
    // Get ids of hashtags
    // get tweets ids
    public function getHashtagsIdsBySubstring($substr){
        $this->db->query("SELECT id FROM hashtag WHERE content LIKE :substr;");

        $this->db->bind(':substr', '%'.$substr.'%');
        $result = $this->db->values();
        return $result;
    }

    public function getTweetIdsByHashtagId($hashtag_id){
        $this->db->query("SELECT tweet_id FROM hashtag_tweets WHERE hashtag_id = :hashtag_id;");

        $this->db->bind(':hashtag_id', $hashtag_id);
        $result = $this->db->values();
        return $result;
    }
}
