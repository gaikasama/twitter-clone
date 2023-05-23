<?php


    class Hashtags extends Controller{
        public function __construct()
        {
            $this->tweetModel = $this->model('Tweet');
            $this->userModel = $this->model('User');
            $this->hashtagModel = $this->model('Hashtag');
        }

        public function getHashtags(){
                    $data = [
                        'result' => false,
                        'user_id' => $_SESSION['user_id'],
                        'hashtag' => trim($_POST['hashtag']),
                    ];
                    // var_dump('%'.$data['hashtag'].'%');

                    // Get all hashtags that include provided substring
                    $result = $this->hashtagModel->getHashtagsBySubstring($data['hashtag']);
                    echo json_encode($result);

                    // if($data['result']){
                    //     $tweet_likes = $this->tweetModel->getLikes($data['tweet_id']);
                    //     $data['likes_count'] = $tweet_likes > 0 ? $tweet_likes : "";
                    //     $data['user_like'] = $this->tweetModel->getUserLike($data['tweet_id'], $data['user_id']);
                    //     echo json_encode($data);
                    // }else{
                    //     $data['error'] = 'Could add like';
                    //     echo json_encode($data);
                    // }
                    
        }

        // public function hashtagSearch($hashtag){
        //     // get all of the tweet ids with provided hashtag
        //     $tweet_ids = [];
        //     echo $hashtag;
        //     $hashtag_ids = json_decode(json_encode($this->hashtagModel->getHashtagsIdsBySubstring($hashtag)), true);
        //     foreach($hashtag_ids as $hash_id){
        //         $tweet_id = json_decode(json_encode($this->hashtagModel->getTweetIdsByHashtagId($hash_id)), true);;
        //         $tweet_ids = array_merge($tweet_ids,$tweet_id);
        //     }

        //     $feed = [''];
        //     // Select * from tweet table
        //     // get type
        //     // get data
            

        //     // Get tweet content
        //     var_dump($hashtag_ids);
        //     var_dump($tweet_ids);


        // }
    
    }