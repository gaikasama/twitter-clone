<?php
    include (APPROOT . '/controllers/Tweets.php');

    class Notifications extends Controller{
        public function __construct()
        {
            $this->imageClass = new Images();
            $this->tweetModel = $this->model('Tweet');
            $this->userModel = $this->model('User');
            $this->hashtagModel = $this->model('Hashtag');
            $this->imageModel = $this->model('Image');
            $this->notificationModel = $this->model('Notification');
        }

        public function checkNotificaitons(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $user_id = $_SESSION['user_id'];
                $result = $this->notificationModel->checkNotifications($user_id);
                echo json_encode($result);
            }
        }

        public function notification($user_id){
            $data = [
                'title' => 'Notifications',
                'nofitications' => ''
            ];
            $notifications = json_decode(json_encode($this->notificationModel->getAllNotificationsByUserId($user_id)),true);
            // var_dump($notifications);

            for($i = 0; $i < count($notifications); $i++){
                $user_info  = json_decode(json_encode($this->userModel->getUser($notifications[$i]['sender_id'])), true); 
                $notifications[$i]['user_info'] = $user_info;

                $avatar = $this->imageModel->getAvatarByUserId($notifications[$i]['sender_id']);
                $notifications[$i]['avatar'] = json_decode(json_encode($avatar), true);

                // get tweets
                $tweet_id = json_decode(json_encode($this->tweetModel->getTweet($notifications[$i]['tweet_id'])),true);
                $tweet_type =  json_decode(json_encode($this->tweetModel->getTweetTypeByTweetId($tweet_id[0]['id'])), true);
                $notifications[$i]['tweet_type'] = $tweet_type['tweet_type'];
            }
            
            

            $data['notifications'] = $notifications;

            $this->view('notifications', $data);

            // Set all notifications status to 1
        }
    }