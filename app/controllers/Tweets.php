<?php
    include (APPROOT . '/controllers/Images.php');

    class Tweets extends Controller{
        public function __construct()
        {
            $this->imageClass = new Images();
            $this->tweetModel = $this->model('Tweet');
            $this->userModel = $this->model('User');
            $this->hashtagModel = $this->model('Hashtag');
            $this->imageModel = $this->model('Image');
            $this->notificationModel = $this->model('Notification');
        }

       


        public function home() {
            $data = [
                'title' => 'Home',
                'feed' => '',
            ];
            $feed = [];

            $tweets = json_decode(json_encode($this->tweetModel->getTweetByType("tweet")), true);
            $retweets = json_decode(json_encode($this->tweetModel->getTweetByType("retweet")), true);
            $comment_retweets = json_decode(json_encode($this->tweetModel->getTweetByType("comment_retweet")), true);

            $tempArr = mergeArraysById($tweets, $retweets);
            $feed_ids = mergeArraysById($tempArr, $comment_retweets);

            
            foreach($feed_ids as $tweet_id){
                $tweet_type =  json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet_id['id'])), true);
               
                if($tweet_type['tweet_type'] === "comment_retweet"){
                    $tweet_data = $this->getCommentRetweet($tweet_id);
                    $tweet_data = array_merge($tweet_data,$tweet_type);

                }elseif($tweet_type['tweet_type'] === "retweet"){
                    $tweet_data = $this->getRetweet($tweet_id);
                    $tweet_data = array_merge($tweet_data,$tweet_type);

                }else{
                    $tweet_data = $this->getTweet($tweet_id);
                    $tweet_data = array_merge($tweet_data,$tweet_type);

                }
                array_push($feed,$tweet_data);
            }

            // echo "<pre>";
            // var_dump($feed[0]);
            // echo "</pre>";
            // echo "<br>";

            $avatar = $this->imageModel->getAvatarByUserId($_SESSION['user_id']);
            $data['avatar'] = json_decode(json_encode($avatar), true);

            $data['feed'] = $feed;
           
            $this->view('home', $data);
        }


        public function tweet($tweet_id){
            $feed = [];
            $tweet = json_decode(json_encode($this->tweetModel->getTweet($tweet_id)), true);
            $tweet_type =  json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet_id)), true);
                
            if($tweet_type['tweet_type'] === "comment_retweet"){
                $tweet_data = $this->getCommentRetweet($tweet[0]);
                $tweet_data = array_merge($tweet_data,$tweet_type);
                $comments = $this->getComment($tweet_id);
                $data['comments'] = $comments;

            }elseif($tweet_type['tweet_type'] === "retweet"){
                $tweet_data = $this->getRetweet($tweet[0]);
                $tweet_data = array_merge($tweet_data,$tweet_type);
                $comments = $this->getComment($tweet_data['retweet']['origin_tweet_id']);
                $data['comments'] = $comments;

            }else{
                $tweet_data = $this->getTweet($tweet[0]);
                $tweet_data = array_merge($tweet_data,$tweet_type);
                $comments = $this->getComment($tweet_id);
                $data['comments'] = $comments;

            }

            $feed[] = $tweet_data;

            $data['feed'] = $feed;
            $data['title'] = "Tweet";
            $this->view('tweet', $data);


        }

        public function profile($user_id){
            $data = [
                'title' => 'Profile',
                'feed' => '',
                'error' => false
            ];
            $feed = [];

            if(gettype($user_id) === 'string'){
                $user = json_decode(json_encode($this->userModel->getUserIdByUserName($user_id)),true);
                if($user){
                    $user_id = $user['id'];
                }else{
                    // header('location:' . URLROOT . '/tweets/home');
                    $data['error'] = "This account doesn't exist.";
                }
                
            }


            $tweets = json_decode(json_encode($this->tweetModel->getTweetByTypeAndUserId($user_id, "tweet")), true);
            $retweets = json_decode(json_encode($this->tweetModel->getTweetByTypeAndUserId($user_id, "retweet")), true);
            $comment_retweets = json_decode(json_encode($this->tweetModel->getTweetByTypeAndUserId($user_id, "comment_retweet")), true);

            $tempArr = mergeArraysById($tweets, $retweets);
            $feed_ids = mergeArraysById($tempArr, $comment_retweets);

            $user_info = json_decode(json_encode($this->userModel->getUser($user_id)), true);

            
            foreach($feed_ids as $tweet_id){
                $tweet_type =  json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet_id['id'])), true);
               
                if($tweet_type['tweet_type'] === "comment_retweet"){
                    $tweet_data = $this->getCommentRetweet($tweet_id);
                    $tweet_data = array_merge($tweet_data,$tweet_type);

                }elseif($tweet_type['tweet_type'] === "retweet"){
                    $tweet_data = $this->getRetweet($tweet_id);
                    $tweet_data = array_merge($tweet_data,$tweet_type);

                }else{
                    $tweet_data = $this->getTweet($tweet_id);
                    $tweet_data = array_merge($tweet_data,$tweet_type);

                }
                array_push($feed,$tweet_data);
            }

            $data['user_following'] = $this->userModel->userFollow($user_id, $_SESSION['user_id']);
            $avatar = $this->imageModel->getAvatarByUserId($user_id);
            $background = $this->imageModel->getBackgroundByUserId($user_id);
            $data['avatar'] = json_decode(json_encode($avatar), true);
            $data['background'] = json_decode(json_encode($background), true);

            
            // echo "<br>";

            $data['user_id'] = $user_id;
            $data['tweet_count'] = $this->tweetModel->getTweetCountByUserId($user_id);
            $data['user_info'] = $user_info;
            $data['title'] = $user_info['nickname'];
            // echo "<pre>";
            // var_dump( $data);
            // echo "</pre>";
            $data['feed'] = $feed;

           
           
            $this->view('profile', $data);
        }


        public function hashtagSearch($hashtag=null){
            $data = [
                'title' => 'Search Result',
                'feed' => '',
            ];

            if(!$hashtag){
                $_POST = filter_input_array(INPUT_POST);
                $hashtag = trim($_POST['hashtag']);
            }

            $tweet_ids = [];
            $tweet_arr = [];
            $tweet_ids = [];
            $feed = [];

            // Get hashtags ids
            $hashtag_ids = json_decode(json_encode($this->hashtagModel->getHashtagsIdsBySubstring($hashtag)), true);

            if(count($hashtag_ids) > 0){
                // Get tweets ids by hashtags id
                foreach($hashtag_ids as $hash_id){
                    $tweet_id = json_decode(json_encode($this->hashtagModel->getTweetIdsByHashtagId($hash_id)), true);;
                    $tweet_ids = array_merge($tweet_ids,$tweet_id);
                }

                // Get tweets info
                foreach($tweet_ids as $tweet_id){
                    $tweet = json_decode(json_encode($this->tweetModel->getTweet($tweet_id)), true);
                    $tweet_arr = array_merge($tweet_arr, $tweet);
                }

                // Get tweet content
                foreach($tweet_arr as $tweet){
                    $tweet_type =  json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet['id'])), true);
                    if($tweet_type['tweet_type'] === "comment_retweet"){
                        $tweet_data = $this->getCommentRetweet($tweet);
                        $tweet_data = array_merge($tweet_data,$tweet_type);

                    }elseif($tweet_type['tweet_type'] === "retweet"){
                        $tweet_data = $this->getRetweet($tweet);
                        $tweet_data = array_merge($tweet_data,$tweet_type);

                    }else{
                        $tweet_data = $this->getTweet($tweet);
                        $tweet_data = array_merge($tweet_data,$tweet_type);

                    }
                    array_push($feed,$tweet_data);
                }
                

                // Get tweet content
                // var_dump($hashtag_ids);
                // var_dump($feed);
                $data['feed'] = $feed;
                $data['result'] = true;

            }else{
                $data['result'] = false;
            }
            $this->view('hashtagsearch', $data);


        }



        public function getTweet($tweet){
            
            $tweet_data = $tweet;
            
            $tweet_data['user_info']  = json_decode(json_encode($this->userModel->getUser($tweet['user_id'])), true); 

            $content = json_decode(json_encode($this->tweetModel->getTweetByTweetId($tweet_data['id'])), true); 
            $content['content'] = splitString($content['content']);
            $tweet_data['content'] = $content;


            $tweet_data['user_like'] = $this->tweetModel->getUserLike($tweet['id'],$_SESSION['user_id']);
            $tweet_data['user_retweet'] = $this->tweetModel->checkUserRetweet($tweet['id'],$_SESSION['user_id']);
            $tweet_data['like_count'] = $this->tweetModel->getLikes($tweet['id']);
            $tweet_data['retweet_count'] = $this->tweetModel->getNumberOfRetweetsByTweetId($tweet['id']);
            $picture_ids = json_decode(json_encode($this->imageModel->getTweetPicturesByTweetId($tweet['id'])),true);

            if(count($picture_ids) > 0){
                foreach($picture_ids as $pic_id){
                    $pictures = json_decode(json_encode($this->imageModel->getPictureByPictureId($pic_id['picture_id'])),true);
                    $tweet_data['pictures'][] = $pictures;
                //     echo "<pre>";
                // var_dump($pictures);
                // echo "</pre>";

                }
            }
            $avatar = $this->imageModel->getAvatarByUserId($tweet_data['user_info']['id']);
            $tweet_data['avatar'] = json_decode(json_encode($avatar), true);
            $tweet_data['comment_count'] = $this->tweetModel->getCommentCount($tweet['id']);

            // echo "<pre>";
            // var_dump($tweet_data);
            // echo "</pre>";
            // TODO comment count
            // TODO pictures

            return $tweet_data;
        }
 
        public function getRetweet($tweet){
            $tweet_data = $tweet;
            $tweet_data['retweet'] = json_decode(json_encode($this->tweetModel->getRetweetByTweetId($tweet['id'])), true); 
           
            // Get origin tweet type
            $origin_tweet_type = json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet_data['retweet']['origin_tweet_id'])), true);
            $tweet_data['origin_tweet_type'] = $origin_tweet_type['tweet_type'];
            $tweet_data['user_info']  = json_decode(json_encode($this->userModel->getUser($tweet_data['user_id'])), true); 
           
            if($origin_tweet_type['tweet_type'] === "tweet"){
                // get retweeted tweet content and highlight hashtags
                $content = json_decode(json_encode($this->tweetModel->getTweetByTweetId($tweet_data['retweet']['origin_tweet_id'])), true); 
                $content['content'] = splitString($content['content']);
                $tweet_data['content'] = $content;
                
                // Get retweeted tweet's user info
                $tweet_data['origin_user_info']  = json_decode(json_encode($this->userModel->getOriginUserByTweetId($tweet_data['retweet']['origin_tweet_id'])), true); 
                
                $picture_ids = json_decode(json_encode($this->imageModel->getTweetPicturesByTweetId($tweet_data['retweet']['origin_tweet_id'])),true);

                if(count($picture_ids) > 0){
                    foreach($picture_ids as $pic_id){
                        $pictures = json_decode(json_encode($this->imageModel->getPictureByPictureId($pic_id['picture_id'])),true);
                        $tweet_data['pictures'][] = $pictures;

                    }
                }

                $avatar = $this->imageModel->getAvatarByUserId($tweet_data['origin_user_info']['id']);
                $tweet_data['avatar'] = json_decode(json_encode($avatar), true);
                
            }else{
                // get comment retweet content
                $content = json_decode(json_encode($this->tweetModel->getCommentRetweetByTweetId($tweet_data['retweet']['origin_tweet_id'])), true);
                $content['content'] = splitString($content['content']);
                $tweet_data['retweet_comment_content'] = $content;
                $tweet_data['retweet_comment_user_info']  = json_decode(json_encode($this->userModel->getOriginUserByTweetId($tweet_data['retweet_comment_content']['tweet_id'])), true); 

                // Get origin tweet conten
                $origin_tweet = json_decode(json_encode($this->tweetModel->getTweetByTweetId($tweet_data['retweet_comment_content']['origin_tweet_id'])), true);
                $origin_tweet['content'] = splitString($origin_tweet['content']);
                $tweet_data['origin_tweet_content'] = $origin_tweet;
                $tweet_data['origin_tweet_user_info']  = json_decode(json_encode($this->userModel->getOriginUserByTweetId($tweet_data['origin_tweet_content']['tweet_id'])), true); 
                
                $avatar = $this->imageModel->getAvatarByUserId($tweet_data['retweet_comment_user_info']['id']);
                $tweet_data['avatar'] = json_decode(json_encode($avatar), true);
            }
            // TODO pictures

            $tweet_data['user_like'] = $this->tweetModel->getUserLike($tweet_data['retweet']['origin_tweet_id'],$_SESSION['user_id']);
            $tweet_data['user_retweet'] = $this->tweetModel->checkUserRetweet($tweet_data['retweet']['origin_tweet_id'],$_SESSION['user_id']);
            $tweet_data['like_count'] = $this->tweetModel->getLikes($tweet_data['retweet']['origin_tweet_id']);
            $tweet_data['retweet_count'] = $this->tweetModel->getNumberOfRetweetsByTweetId($tweet_data['retweet']['origin_tweet_id']);
            $tweet_data['comment_count'] = $this->tweetModel->getCommentCount($tweet_data['retweet']['origin_tweet_id']);
 
            return $tweet_data;
         }
 
         public function getCommentRetweet($tweet){
            $tweet_data = $tweet;

            // Get comment retweet content
            $content = json_decode(json_encode($this->tweetModel->getCommentRetweetByTweetId($tweet_data['id'])), true);
            $content['content'] = splitString($content['content']);
            $tweet_data['retweet_comment_content'] = $content;
            $tweet_data['user_info']  = json_decode(json_encode($this->userModel->getUser($tweet_data['user_id'])), true); 

            // Get origin tweet content and user info
            // Get origin tweet type
            $origin_tweet_type = json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet_data['retweet_comment_content']['origin_tweet_id'])), true);
            $tweet_data['origin_tweet_type'] = $origin_tweet_type['tweet_type'];
            if($tweet_data['origin_tweet_type'] === "tweet"){
                $origin_tweet = json_decode(json_encode($this->tweetModel->getTweetByTweetId($tweet_data['retweet_comment_content']['origin_tweet_id'])), true);
                $origin_tweet['content'] = splitString($origin_tweet['content']);
                $tweet_data['origin_tweet_content'] = $origin_tweet;
                $tweet_data['origin_tweet_user_info']  = json_decode(json_encode($this->userModel->getOriginUserByTweetId($tweet_data['origin_tweet_content']['tweet_id'])), true);
            }elseif($tweet_data['origin_tweet_type'] === "comment_retweet"){
                $origin_tweet = json_decode(json_encode($this->tweetModel->getCommentRetweetByTweetId($tweet_data['retweet_comment_content']['origin_tweet_id'])), true);
                $origin_tweet['content'] = splitString($origin_tweet['content']);
                $tweet_data['origin_tweet_content'] = $origin_tweet;
                $tweet_data['origin_tweet_user_info']  = json_decode(json_encode($this->userModel->getOriginUserByTweetId($tweet_data['retweet_comment_content']['tweet_id'])), true);
            }elseif($tweet_data['origin_tweet_type'] === "retweet"){
                $origin_tweet = json_decode(json_encode($this->tweetModel->getRetweetByTweetId($tweet_data['retweet_comment_content']['origin_tweet_id'])), true);
                $origin_tweet['content'] = splitString($origin_tweet['content']);
                $tweet_data['origin_tweet_content'] = $origin_tweet;
                $tweet_data['origin_tweet_user_info']  = json_decode(json_encode($this->userModel->getOriginUserByTweetId($tweet_data['retweet_comment_content']['tweet_id'])), true);
            }

            $picture_ids = json_decode(json_encode($this->imageModel->getTweetPicturesByTweetId($tweet_data['id'])),true);

                if(count($picture_ids) > 0){
                    foreach($picture_ids as $pic_id){
                        $pictures = json_decode(json_encode($this->imageModel->getPictureByPictureId($pic_id['picture_id'])),true);
                        $tweet_data['pictures'][] = $pictures;

                    }
                }
             
            $avatar = $this->imageModel->getAvatarByUserId($tweet_data['user_info']['id']);
            $tweet_data['avatar'] = json_decode(json_encode($avatar), true);

            // Get likes and retweets count and user info
            $tweet_data['user_like'] = $this->tweetModel->getUserLike($tweet_data['id'],$_SESSION['user_id']);
            $tweet_data['user_retweet'] = $this->tweetModel->checkUserRetweet($tweet_data['id'],$_SESSION['user_id']);
            $tweet_data['like_count'] = $this->tweetModel->getLikes($tweet_data['id']);
            $tweet_data['retweet_count'] = $this->tweetModel->getNumberOfRetweetsByTweetId($tweet_data['id']);
            $tweet_data['comment_count'] = $this->tweetModel->getCommentCount($tweet_data['id']);
            // echo "<pre>";
            // var_dump($tweet_data);
            // echo "</pre>";

           return $tweet_data;
         }


         public function getComment($tweet_id){
            $comments = json_decode(json_encode($this->tweetModel->getComments($tweet_id)), true);
            
            for($i = 0; $i < count($comments); $i++){
                $comments[$i]['user_info'] = json_decode(json_encode($this->userModel->getOriginUserByTweetId($comments[$i]['tweet_id'])), true); 
                $comments[$i]['user_like'] =  $this->tweetModel->getUserLike($comments[$i]['tweet_id'],$_SESSION['user_id']);
                $comments[$i]['like_count'] = $this->tweetModel->getLikes($comments[$i]['tweet_id']);
            }
          
            // echo "<pre>";
            // var_dump($comments);
            // echo "</pre>";

            return $comments;
         }  

        

        public function postTweet(){
            if(isset($_POST['post_tweet'])){
                $_POST = filter_input_array(INPUT_POST);
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'content' => trim($_POST['content']),
                    'hashtags' => $_POST['hashtags'],
                    'type' => $_POST['type'],
                    'images' => $_POST['images'],
                ];

                if($this->tweetModel->postTweet($data)){
                    
                    if(count($data['hashtags']) > 0){
                        $tweet_id = $this->tweetModel->getLastInsertId();

                        $res = false;
                        foreach($data['hashtags'] as $hash){
                        $hashtag_id = $this->hashtagModel->getHashtagIdByHashtag($hash);
                        if(!$hashtag_id){
                            $this->hashtagModel->postHashtag($hash);
                            $hashtag_id = $this->hashtagModel->getHashtagIdByHashtag($hash);
                        }

                        $res = $this->hashtagModel->postTweetHashtag($hashtag_id, $tweet_id);
                            if(!$res){
                                break;
                            }
                        }

                        if(count($data['images']) > 0){
                            foreach($data['images'] as $img){
                                $res = $this->imageModel->savePictureAndTweet($tweet_id, $img);
                                if(!$res){
                                    break;
                                }
                            }
                        }
                        echo json_encode($res);
                    }else{
                        echo json_encode(true);
                    }
                    
                }   

            }
            

            // header('location:' . URLROOT . '/tweets/home');
        }

        public function retweet(){
            if(isset($_POST['retweet'])){
                $_POST = filter_input_array(INPUT_POST);
                $data = [
                    'type' => trim($_POST['retweet']),
                    'user_id' => $_SESSION['user_id'],
                    'origin_tweet_id' => trim($_POST['origin_tweet_id']),
                ];
                if($this->tweetModel->postRetweet($data)){
                    $data['retweet_count'] = $this->tweetModel->getNumberOfRetweetsByTweetId($data['origin_tweet_id']);
                    // save notification
                    $receiver_id = json_decode(json_encode($this->userModel->getOriginUserByTweetId($data['origin_tweet_id'])), true);
                    $notification_data = [
                        'type' => "retweet",
                        'tweet_id' => $data['origin_tweet_id'],
                        'sender_id' => $_SESSION['user_id'],
                        'receiver_id' => $receiver_id['id'],
                    ];
                    $this->notificationModel->saveNotification($notification_data);
                    
                    echo json_encode($data);
                }else{
                    $data['error'] = "Couldn't retweet ";
                    echo json_encode($data);
                }
            }
            
        }

        public function undoRetweet(){
            if(isset($_POST['undo_retweet'])){
                $_POST = filter_input_array(INPUT_POST);

                $tweet_id = $_POST['retweet_id'];
                $tweet_type = $_POST['tweet_type'];
                $user_id = $_SESSION['user_id'];

                // When retweet is being deleted from the original tweet 
                // First fetch retweet_id by original_tweet_id and user_id
                if($tweet_type === 'tweet'){
                    $tweet = json_decode(json_encode($this->tweetModel->getRetweetByTweetIdAndUserId($tweet_id, $user_id)), true);
                    $tweet_id = $tweet['tweet_id'];
                }
                
                if($this->tweetModel->undoRetweet($tweet_id)){
                    $origin_tweet = json_decode(json_encode($this->tweetModel->getRetweetOriginTweetIdByTweetId($tweet_id)),true);
                    // var_dump($origin_tweet);
                    $data['tweet_id'] = $tweet_id;
                    $data['origin_tweet_id'] = $origin_tweet['id'];
                    $data['retweet_count'] = $this->tweetModel->getNumberOfRetweetsByTweetId($origin_tweet['id']);
                    $data['result'] = true;
                    echo json_encode($data);
                }else{
                    echo json_encode(false);
                }
            }
        }



        public function commentRetweet(){
            $_POST = filter_input_array(INPUT_POST);
            $data = [
                'type' => trim($_POST['type']),
                'user_id' => $_SESSION['user_id'],
                'origin_tweet_id' => trim($_POST['originTweetId']),
                'content' => trim($_POST['content']),
            ];
            // var_dump($data);
            $this->tweetModel->postCommentRetweet($data);
            header('location:' . URLROOT . '/tweets/home');
        }



        public function like(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);

                if(isset($_POST['like']))
                {
                    $data = [
                        'result' => false,
                        'user_id' => $_SESSION['user_id'],
                        'tweet_id' => trim($_POST['tweet_id']),
                        'likes_count' => 0
                    ];

                    // Check if this user already liked tweet
                    // And add or delete like
                    if($this->tweetModel->getUserLike($data['tweet_id'], $data['user_id'])){

                        if($this->tweetModel->deleteLike($data)){
                            $data['result'] = true;
                        }
                    } else{
                        if($this->tweetModel->postLike($data)){
                            $receiver_id = json_decode(json_encode($this->userModel->getOriginUserByTweetId($data['tweet_id'])), true);
                            // Save notification
                            $notification_data = [
                                'type' => "like",
                                'tweet_id' => $data['tweet_id'],
                                'sender_id' => $_SESSION['user_id'],
                                'receiver_id' => $receiver_id['id'],
                            ];
                            $this->notificationModel->saveNotification($notification_data);
                            
                            $data['result'] = true;
                        }
                    }


                    if($data['result']){
                        $tweet_likes = $this->tweetModel->getLikes($data['tweet_id']);
                        $data['likes_count'] = $tweet_likes > 0 ? $tweet_likes : "";
                        $data['user_like'] = $this->tweetModel->getUserLike($data['tweet_id'], $data['user_id']);
                        echo json_encode($data);
                    }else{
                        $data['error'] = 'Could add like';
                        echo json_encode($data);
                    }
                    
                }
            }
        }

        public function comment(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);

                    $data = [
                        'result' => false,
                        'type' => trim($_POST['type']),
                        'user_id' => $_SESSION['user_id'],
                        'tweet_id' => trim($_POST['tweet_id']),
                        'content' => trim($_POST['comment']),
                    ];
                    // var_dump($data);
                    if($this->tweetModel->postComment($data)){
                        // $result = $this->tweetModel->postComment($data);
                        // save notification
    
                        // $receiver_id = json_decode(json_encode($this->userModel->getOriginUserByTweetId($data['tweet_id'])), true);
    
                        // $notification_data = [
                        //     'type' => "comment",
                        //     'tweet_id' => $data['tweet_id'],
                        //     'sender_id' => $_SESSION['user_id'],
                        //     'receiver_id' => $receiver_id['id'],
                        // ];
                        // $test = $this->notificationModel->saveNotification($notification_data);
                        // var_dump($test);

                        echo json_encode(true);
                    }else{
                        echo json_encode(false);

                    }

                    


                    // header('location:' . URLROOT . '/tweets/home');
            }
        }

       public function checkUserRetweet(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);
                $user_id = $_SESSION['user_id'];
                $tweet_id = trim($_POST['tweet_id']);

            if($this->tweetModel->checkUserRetweet($tweet_id, $user_id)){
                    echo json_encode(true);
                }else{
                    echo json_encode(false);
                }
            }
        }


        // public function getRetweetContent(){
        //     $contentType = $this->db->getOriginTweetTypeByTweetId();
        // }

        
    }
