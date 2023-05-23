<?php

    class Images extends Controller{

        public function __construct()
        {
            $this->tweetModel = $this->model('Tweet');
            $this->userModel = $this->model('User');
            $this->hashtagModel = $this->model('Hashtag');
            $this->imageModel = $this->model('Image');
        }
    
        public function uploadTweetImage(){
            
            $img = $_FILES['image'];
            $imgName = $_FILES['image']['name'];
            $imgTmpName = $_FILES['image']['tmp_name'];
            $imgSize = $_FILES['image']['size'];
            $imgError = $_FILES['image']['error'];
            $imgType = $_FILES['image']['type'];
            // echo "<pre>";
            // var_dump($_FILES);
            // var_dump($imgTmpName);
            // echo "</pre>";

            $imgExt = explode('.', $imgName);
            $extention = strtolower(end($imgExt));

            $allowedExt = array("jpg", "jpeg", "png", "svg");
            
            if(in_array($extention, $allowedExt)){
                if($imgError === 0){
                    if($imgSize < 1000000){
                        $fileNameNew = uniqid("", true).".".$extention;
                        
                        $destination_path = getcwd().DIRECTORY_SEPARATOR."/assets/tweet/";
                        $target_path = $destination_path . basename($fileNameNew);

                        $moved = move_uploaded_file($imgTmpName,$target_path);
                        // echo $fileNameNew;
                        // echo $target_path;
                        // var_dump($moved);

                        if( $moved ) {
                            // save to db
                            $data = [
                                "picture_name" => $fileNameNew,
                                "path" => $destination_path
                            ];
                            
                            if($this->imageModel->saveTweetPicture($data)){
                                $img_id = $this->getPictureId($fileNameNew);
                                $data = [
                                    "result" => true,
                                    'img_id' => $img_id,
                                    "img_src" => $target_path,
                                    "img_name" => $fileNameNew,
                                    "img" => URLROOT."/public/assets/tweet/".$fileNameNew
                                ];
                                echo json_encode($data);         

                            }else{
                                unlink($target_path);
                            }
                        } else {
                            unlink($target_path);
                            echo "Not uploaded because of error #".$_FILES["image"]["error"];
                        }
                    }else{
                        echo "Image size exceeds 10mb";
                    }
                }else{
                    echo "There was an error";
                }
            }else{
                echo "This file extention is not allowed";
            }

            $data = "I am running";
            return $data;
        }


        public function getPictureId($img_name){
            $image_id = $this->imageModel->getPictureIdByName($img_name);
            return $image_id;

        }

        public function uploadProfileImage(){
            $img = $_FILES['image'];
            $imgName = $_FILES['image']['name'];
            $imgTmpName = $_FILES['image']['tmp_name'];
            $imgSize = $_FILES['image']['size'];
            $imgError = $_FILES['image']['error'];
            $imgType = $_FILES['image']['type'];
            $type = trim($_POST['type']);
            // echo "<pre>";
            // var_dump($_FILES);
            // var_dump($_POST);
            // echo "</pre>";

            $imgExt = explode('.', $imgName);
            $extention = strtolower(end($imgExt));

            $allowedExt = array("jpg", "jpeg", "png", "svg");
            
            if(in_array($extention, $allowedExt)){
                if($imgError === 0){
                    if($imgSize < 1000000){
                        $fileNameNew = uniqid("", true).".".$extention;
                        
                        $destination_path = getcwd().DIRECTORY_SEPARATOR."/assets/profile/".$type."/";
                        $target_path = $destination_path . basename($fileNameNew);

                        $moved = move_uploaded_file($imgTmpName,$target_path);
                        // echo $fileNameNew;
                        // echo $target_path;
                        // var_dump($moved);

                        if( $moved ) {
                            // save to db
                            $data = [
                                "picture_name" => $fileNameNew,
                                "path" => $destination_path
                            ];
                            
                            if($this->imageModel->saveTweetPicture($data)){
                                $img_id = $this->getPictureId($fileNameNew);
                                $data = [
                                    "result" => true,
                                    'img_id' => $img_id,
                                    "img_src" => $target_path,
                                    "img_name" => $fileNameNew,
                                    "img" => URLROOT."/assets/profile/".$type."/".$fileNameNew
                                ];
                                echo json_encode($data);         

                            }else{
                                unlink($target_path);
                            }
                        } else {
                            unlink($target_path);
                            echo "Not uploaded because of error #".$_FILES["image"]["error"];
                        }
                    }else{
                        echo "Image size exceeds 10mb";
                    }
                }else{
                    echo "There was an error";
                }
            }else{
                echo "This file extention is not allowed";
            }

            $data = "I am running";
            return $data;
        }

        
    
    }