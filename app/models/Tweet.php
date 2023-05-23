<?php


class Tweet{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    // -----------------------------------------------------
    // GENERAL TWEET TABLE
    // -----------------------------------------------------
        public function getTweetIds(){
            $this->db->query("SELECT * FROM tweet ORDER BY id DESC LIMIT 30 ;");
            $result = $this->db->resultSet();
            return $result; 
        }

        public function getTweet($tweet_id){
            $this->db->query("SELECT * FROM tweet WHERE id = :tweet_id;");

            $this->db->bind(':tweet_id', $tweet_id);
            $result = $this->db->resultSet();
            return $result; 
        }

        public function getTweetByType($tweet_type){
            $this->db->query("SELECT * FROM tweet WHERE type_id = (SELECT id FROM tweet_types WHERE name = :tweet_type) AND delete_flg = 0 ORDER BY id DESC;");
            $this->db->bind(':tweet_type', $tweet_type);
            $result = $this->db->resultSet();
            return $result; 
        }

        public function getUserIdByTweetId($tweet_id){
            $this->db->query("SELECT user_id FROM tweet WHERE id = :tweet_id");
            $this->db->bind(':tweet_id', $tweet_id);
            $result = $this->db->single();
            return $result;
        }

       

        public function getLastInsertId(){
            $this->db->query("SELECT LAST_INSERT_ID()");
            $result = $this->db->singleValue();
            return $result;
        }

        public function getTweetByTypeAndUserId($user_id, $type){
            $this->db->query("SELECT * FROM tweet WHERE user_id=:user_id AND type_id = (SELECT id FROM tweet_types WHERE name = :tweet_type) AND delete_flg = 0 ORDER BY id DESC;");
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':tweet_type', $type);
            $result = $this->db->resultSet();
            return $result; 
        }

        public function getTweetCountByUserId($user_id){
            $this->db->query("SELECT * FROM tweet WHERE user_id = :user_id AND delete_flg = 0");
            $this->db->bind(':user_id', $user_id);
            $this->db->execute();

            return $this->db->rowCount();
        }
  

    // -----------------------------------------------------
    // TWEET
    // -----------------------------------------------------

    // TODO break queries into smaller functions to avoid joins
    //Get tweets
    public function getTweets()
    {
        //Prepared statement
        $this->db->query("SELECT tweet.id, tweet.user_id, tweet_types.name as tweet_type, content
        FROM tweet 
        LEFT JOIN tweet_tweets ON tweet.id = tweet_tweets.tweet_id 
        LEFT JOIN tweet_types ON tweet.type_id = tweet_types.id 
        WHERE tweet.delete_flg = 0
        ORDER BY tweet.id DESC;");

        //Execute function and get all rows that satisfy statement
        $result = $this->db->resultSet();
        return $result;
    }

    // Post tweet
    public function postTweet($data){
        //Prepare statement
        $this->db->query('INSERT INTO tweet (type_id, user_id) VALUES ((SELECT id FROM tweet_types WHERE tweet_types.name = :type), :user_id);
        INSERT INTO tweet_tweets (tweet_tweets.tweet_id, tweet_tweets.content) VALUES (LAST_INSERT_ID(), :content);');

        //Bind values
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':content', $data['content']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTweetContentByTweetId($tweet_id){
        $this->db->query('SELECT content FROM tweet_tweets WHERE tweet_id = :tweet_id');
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->single();
        return $result;
    }

    public function getTweetByTweetId($tweet_id){
        $this->db->query('SELECT * FROM tweet_tweets WHERE tweet_id = :tweet_id');
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->single();
        return $result;
    }


    // -----------------------------------------------------
    // RETWEET
    // -----------------------------------------------------

    // TODO break queries into smaller functions to avoid joins
    // TODO get retweeted content based on original tweet type
    //Get retweets
    public function getRetweets()
    {
        //Prepared statement
        $this->db->query("SELECT tweet.id, tweet.user_id, tweet_types.name AS tweet_type, tweet_retweets.origin_tweet_id
        FROM tweet
        LEFT JOIN tweet_retweets ON tweet.id = tweet_retweets.tweet_id
        LEFT JOIN tweet_types ON tweet.type_id = tweet_types.id
        WHERE tweet.delete_flg = 0 ORDER BY tweet.id DESC;");

        //Execute function and get all rows that satisfy statement
        $result = $this->db->resultSet();
        return $result;
    }

    // Post retweet
    public function postRetweet($data){
        $this->db->query("INSERT INTO tweet(type_id, user_id) 
        VALUES ((SELECT id FROM tweet_types WHERE tweet_types.name = :type), :user_id);
        INSERT INTO tweet_retweets (tweet_id, origin_tweet_id) 
        VALUES (LAST_INSERT_ID(), :origin_tweet_id);");

        $this->db->bind(':type', $data['type']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':origin_tweet_id', $data['origin_tweet_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getRetweetByTweetIdAndUserId($tweet_id, $user_id){
        $this->db->query('SELECT * FROM tweet_retweets LEFT JOIN tweet on tweet.id = tweet_retweets.tweet_id WHERE origin_tweet_id = :tweet_id and user_id = :user_id AND tweet.delete_flg = 0;');
        $this->db->bind(':tweet_id', $tweet_id);
        $this->db->bind(':user_id', $user_id);

        $result = $this->db->single();
        return $result;
    }

    public function getRetweetByTweetId($tweet_id){
        $this->db->query('SELECT * FROM tweet_retweets WHERE tweet_id = :tweet_id;');
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->single();
        return $result;
    }

    // Check if user retweeted tweet byt origin_tweet_id and user_id
    public function checkUserRetweet($tweet_id, $user_id){
        $this->db->query("SELECT * FROM tweet_retweets 
        LEFT JOIN tweet on tweet_retweets.tweet_id = tweet.id 
        WHERE tweet.user_id = :user_id AND tweet_retweets.origin_tweet_id = :tweet_id AND tweet.delete_flg = 0;");

        $this->db->bind(':tweet_id', $tweet_id);
        $this->db->bind(':user_id', $user_id);

        //Execute function
        $this->db->execute();
        
        //Check if user liked tweet
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Get total number of retweets
    public function getNumberOfRetweetsByTweetId($tweet_id){
        //Prepare statement
        $this->db->query("SELECT * FROM tweet_retweets LEFT JOIN tweet on tweet.id = tweet_retweets.tweet_id WHERE origin_tweet_id = :tweet_id AND tweet.delete_flg = 0");

        //Bind values
        $this->db->bind(':tweet_id', $tweet_id);
        
        //Execute function
        $this->db->execute();

        return $this->db->rowCount();
    }

    // Get retweet's origin ID by retweets id
    public function getRetweetOriginTweetIdByTweetId($tweet_id){
        $this->db->query("SELECT origin_tweet_id AS id FROM tweet_retweets where tweet_id = :tweet_id");
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->single();
        return $result;
    }

    public function undoRetweet($tweet_id){
        $this->db->query("UPDATE tweet SET delete_flg = 1 WHERE id = :id");
        $this->db->bind(':id', $tweet_id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // -----------------------------------------------------
    // COMMENT RETWEET
    // -----------------------------------------------------

    // TODO break queries into smaller functions to avoid joins\
    // TODO get retweeted content based on original tweet type
    // Get comment retweet
    public function getCommentRetweets()
    {
        $this->db->query('SELECT tweet.id, user_id, tweet_types.name AS tweet_type, tweet_comment_retweet.content, tweet_comment_retweet.origin_tweet_id, tweet_tweets.content AS origin_content
        FROM tweet
        LEFT JOIN tweet_comment_retweet ON tweet.id = tweet_comment_retweet.tweet_id
        LEFT JOIN tweet_types ON tweet.type_id = tweet_types.id
        LEFT JOIN tweet_tweets ON tweet_tweets.tweet_id = tweet_comment_retweet.origin_tweet_id
        WHERE tweet.delete_flg = 0 ORDER BY tweet.id DESC;');

        //Execute function and get all rows that satisfy statement
        $result = $this->db->resultSet();
        return $result;

    }

    public function getCommentRetweetByTweetId($tweet_id){
        $this->db->query("SELECT * FROM tweet_comment_retweet WHERE tweet_id = :tweet_id;");
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->single();
        return $result;
    }

    // Get comment retweet by tweet id
    public function getCommentRetweet($tweet_id){
        $this->db->query('SELECT tweet_comment_retweet.content, tweet_comment_retweet.origin_tweet_id, tweet_tweets.content AS origin_content
        FROM tweet
        LEFT JOIN tweet_comment_retweet ON tweet.id = tweet_comment_retweet.tweet_id
        LEFT JOIN tweet_tweets ON tweet_tweets.tweet_id = tweet_comment_retweet.origin_tweet_id
        WHERE tweet.delete_flg = 0 AND tweet_comment_retweet.tweet_id = :tweet_id ;');

        $this->db->bind(':tweet_id', $tweet_id);
        
        //Execute function and get all rows that satisfy statement
        $result = $this->db->single();
        return $result;
    }

    // Get retweet's origin ID by retweets id
    public function getCommentRetweetOriginTweetIdByTweetId($tweet_id){
        $this->db->query("SELECT origin_tweet_id AS id FROM tweet_comment_retweet where tweet_id = :tweet_id");
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->single();
        return $result;
    }

    // Post commented retweet
    public function postCommentRetweet($data){
        $this->db->query("INSERT INTO tweet(type_id, user_id) 
        VALUES ((SELECT id FROM tweet_types WHERE tweet_types.name = :type), :user_id);
        INSERT INTO tweet_comment_retweet (tweet_comment_retweet.tweet_id, tweet_comment_retweet.origin_tweet_id, tweet_comment_retweet.content) 
        VALUES (LAST_INSERT_ID(), :origin_tweet_id, :content);");

        $this->db->bind(':type', $data['type']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':origin_tweet_id', $data['origin_tweet_id']);
        $this->db->bind(':content', $data['content']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // -----------------------------------------------------
    // COMMENTS
    // -----------------------------------------------------
    public function postComment($data){
        $this->db->query("INSERT INTO tweet(type_id, user_id) 
        VALUES ((SELECT id FROM tweet_types WHERE tweet_types.name = :type), :user_id);
        INSERT INTO tweet_comments (tweet_id, origin_tweet_id, content) 
        VALUES (LAST_INSERT_ID(), :origin_tweet_id, :content);");

        $this->db->bind(':type', $data['type']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':origin_tweet_id', $data['tweet_id']);
        $this->db->bind(':content', $data['content']);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    // TODO: 

    // Get number of comments by tweet_id
    public function getCommentCount($tweet_id){
        //Prepare statement
        $this->db->query("SELECT * FROM tweet_comments WHERE origin_tweet_id = :tweet_id ");

        //Bind values
        $this->db->bind(':tweet_id', $tweet_id);
        
        //Execute function
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getComments($tweet_id){
        $this->db->query("SELECT * FROM tweet_comments WHERE origin_tweet_id = :tweet_id ORDER BY tweet_id DESC;");
        $this->db->bind(':tweet_id', $tweet_id);
        $result = $this->db->resultSet();
        return $result;
    }

    // -----------------------------------------------------
    // TWEET TYPES
    // -----------------------------------------------------

    public function getTweetTypeByTweetId($tweet_id){
        $this->db->query('SELECT tweet_types.name AS tweet_type FROM tweet_types
        LEFT JOIN tweet ON tweet.type_id = tweet_types.id 
        WHERE tweet.id = :tweet_id ');

        $this->db->bind(':tweet_id', $tweet_id);

        $result = $this->db->single();
        return $result;
    }

    // -----------------------------------------------------
    // LIKES
    // -----------------------------------------------------
    public function postLike($data){
        $this->db->query("INSERT INTO tweet_likes (tweet_id, user_id) VALUES (:tweet_id, :user_id)");

        $this->db->bind(':tweet_id', $data['tweet_id']);
        $this->db->bind(':user_id', $data['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteLike($data){
        $this->db->query("DELETE FROM tweet_likes WHERE tweet_id = :tweet_id AND user_id = :user_id");

        $this->db->bind(':tweet_id', $data['tweet_id']);
        $this->db->bind(':user_id', $data['user_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get tweets likes
    public function getLikes($tweet_id){
        //Prepare statement
        $this->db->query("SELECT * FROM tweet_likes WHERE tweet_id = :tweet_id ");

        //Bind values
        $this->db->bind(':tweet_id', $tweet_id);
        
        //Execute function
        $this->db->execute();

        return $this->db->rowCount();
    }

   
    // Check if user liked tweet
    public function getUserLike($tweet_id, $user_id){
        $this->db->query("SELECT * FROM tweet_likes WHERE tweet_id = :tweet_id AND user_id = :user_id");
        $this->db->bind(':tweet_id', $tweet_id);
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
}