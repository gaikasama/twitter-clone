<?php

    class Users extends Controller{
        public function __construct()
        {
            $this->userModel = $this->model('User');
            $this->notificationModel = $this->model('Notification');
        }

        // ---------------------- //
        // LOGIN                  //
        // ---------------------- //
        public function login() {    
            $data = [
                'title' => 'Login page',
                'email' => '',
                'password' => '',
                'emailError' => '',
                'passwordError' => '',
                'loginError' =>''
            ];

            // Login form submit handler
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);
                $data = [
                    'title' => 'Login page',
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'emailError' => '',
                    'passwordError' => '',
                    'loginError' =>''
                ];

                // Check if any of the inputs empty
                // if (empty($data['email']) || empty($data['password'])) {
                //     $data['loginError'] = 'Password or email is incorrect. Please try again.';

                //     $this->view('index', $data);
                // }

                // Validate email
                // $emailValid = checkValidEmail($data['email']);
                //  if(!$emailValid['result']){
                //      $data['emailError'] = $emailValid['error'];
                //   }
                
                
                //Check if all errors are empty
                if (empty($data['emailError']) && empty($data['passwordError'])) {
                    // Login 
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if ($loggedInUser) {
                        // Set session variables
                        createUserSession($loggedInUser);
                        $this->view('home',$data);
                    } else {
                        $data['loginError'] = 'Password or email is incorrect. Please try again.';

                        $this->view('home', $data);
                    }
                }

            };
            $this->view('registration', $data);
        }


        // ---------------------- //
        // REGISTER               //
        // ---------------------- //
        public function registration(){
            $data = [
            'title' => 'Sign up',
            'username' => '',
            'email' => '',
            'nickname' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'nicknameError' => '',
            'passwordError' => '',
            'confirmPasswordError' => '',
        ];

            // if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //     //Sanitize post data
            //     $_POST = filter_input_array(INPUT_POST);

            //     $data = [
            //         'title' => 'Sign up',
            //         'username' => trim($_POST['username']),
            //         'nickname' => trim($_POST['nickname']),
            //         'email' => trim($_POST['email']),
            //         'password' => trim($_POST['password']),
            //         'confirmPassword' => trim($_POST['confirm_password']),
            //         'usernameError' => '',
            //         'emailError' => '',
            //         'passwordError' => '',
            //         'confirmPasswordError' => '',
            //         'nicknameError' => ''
            //     ];
            //     var_dump($data);

            //     // VALIDATE INPUTS

            //     // Check if address is empty
            //     $checkEmptyInput = checkEmptyInputs(array('address' => $data['address']));
            //     if(!$checkEmptyInput['result']){
            //         foreach($checkEmptyInput['errors'] as $key => $val){
            //             $data[$key] = $val;
            //         }
            //     }

            //     // Validate name
            //     $firstNameValid = checkValidName($data['firstName']);
            //      if(!$firstNameValid['result']){
            //          $data['firstNameError'] = $firstNameValid['error'];
            //       }

            //     $lastNameValid = checkValidName($data['lastName']);
            //     if(!$lastNameValid['result']){
            //         $data['lastNameError'] = $lastNameValid['error'];
            //     }

            //     // Validate email
            //     $emailValid = checkValidEmail($data['email']);
            //      if(!$emailValid['result']){
            //          $data['emailError'] = $emailValid['error'];
            //       }else{
            //           //Check if email exists.
            //         if ($this->userModel->findUserByEmail($data['email'])) {
            //             $data['emailError'] = 'Email is already taken.';
            //         }
            //       }
                
            //       // Validate password
            //       $passwordValid = checkValidPassword($data['password']);
            //       if(!$passwordValid['result']){
            //         $data['passwordError'] = $passwordValid['error'];
            //       }
                    
            //       // Check confirm password
            //       $checkPassword = checkPasswords($data['password'], $data['confirmPassword']);
            //       if(!$checkPassword['result']){
            //         $data['confirmPasswordError'] = $checkPassword['error'];
            //       }


            //       if (empty($data['nameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError']) && empty($data['addressError'])){
            //          // Hash password
            //          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            //          //Register user from model function
            //         if ($this->userModel->register($data)) {
            //             //Redirect to the login page
            //             header('location: ' . URLROOT);
            //         } else {
            //             die('Something went wrong.');
            //         }
                    
            //       }
            // };
            
            $this->view('registration', $data);
        }

        // ---------------------- //
        // SIGN UP                //
        // ---------------------- //


        public function signup(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);

                $data = [
                    'title' => 'Sign up',
                    'step' => trim($_POST['step']),
                    'username' => trim($_POST['username']),
                    'nickname' => trim($_POST['nickname']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirmPassword' => trim($_POST['confirm_password']),
                    'errors' => [],
                    'result' => true
                ];

                if($data['step'] === '1'){
                    
                    // check username
                    $usernameCheck = checkValidName($data['username']);
                    if(!$usernameCheck['result']){
                        $data['result'] = false;
                        $data['errors']['usernameError'] = $usernameCheck['error'];
                    }
                    
                    // check email
                    $emailCheck = checkValidEmail($data['email']);
                    if(!$emailCheck['result']){
                        $data['result'] = false;
                        $data['errors']['emailError'] = $emailCheck['error'];
                    }else{
                        if ($this->userModel->findUserByEmail($data['email'])) {
                            $data['result'] = false;
                            $data['errors']['emailError'] = 'Email is already taken.';
                        }
                    }
                    echo json_encode($data);

                }elseif($data['step'] === '2'){

                    // check if nickname is empty
                    $checkEmptyInput = checkEmptyInputs(array('nickname' => $data['nickname']));
                    if(!$checkEmptyInput['result']){
                        $data['result'] = false;
                        $data['errors'] = $checkEmptyInput['errors'];
                    }

                    // Validate password
                    $passwordValid = checkValidPassword($data['password']);
                    if(!$passwordValid['result']){
                        $data['result'] = false;
                        $data['errors']['passwordError'] = $passwordValid['error'];
                    }

                    // Check confirm password
                    $checkPassword = checkPasswords($data['password'], $data['confirmPassword']);
                    if(!$checkPassword['result']){
                        $data['result'] = false;
                        $data['errors']['confirmPasswordError'] = $checkPassword['error'];
                    }


                    if(count($data['errors']) === 0){
                        // Hash password
                        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                        //  Register user from model function
                        if ($this->userModel->register($data)) {
                            $loggedInUser = $this->userModel->login($data['email'], $data['confirmPassword']);

                            if ($loggedInUser) {
                                // Set session variables
                                createUserSession($loggedInUser);
                            }
                        } else {
                            $data['result'] = false;
                            $data['registrationError'] = 'Something went wrong';
                        }
                    }

                    echo json_encode($data);
                }

            };

        }

        // ---------------------- //
        // HOME (USER LIST)       //
        // ---------------------- //
        // public function home() {
        //     if(isLoggedIn()){
        //         $users = json_decode(json_encode($this->userModel->getUsers()), true);
        //         $data = [
        //             'title' => 'Home',
        //             'users' => $users
        //         ];
        //         $this->view('home', $data);
        //     } else {
        //         $this->logout();
        //     }
        // }
        // public function home() {
        //     // $users = json_decode(json_encode($this->userModel->getUsers()), true);
        //     $data = [
        //         'title' => 'Home',
        //         'users' => ''
        //     ];
        //     $this->view('home', $data);
        // }

        // ---------------------- //
        // EDIT USER              //
        // ---------------------- //
        // public function editUser() {
        //     if(isLoggedIn()){
        //         if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //             //Sanitize post data
        //             $_POST = filter_input_array(INPUT_POST);
        //             if(isset($_POST['edit_row']))
        //             {
        //                 $data = [
        //                     'id' => trim($_POST['id']),
        //                     'firstName' => trim($_POST['firstName']),
        //                     'lastName' => trim($_POST['lastName']),
        //                     'email' => trim($_POST['email']),
        //                     'firstNameError'=> '',
        //                     'lastNameError'=> '',
        //                     'emailError' => '',
        //                     'result' => false
        //                 ];

        //                 // Validate name
        //                 $firstNameValid = checkValidName($data['firstName']);
        //                 if(!$firstNameValid['result']){
        //                     $data['firstNameError'] = $firstNameValid['error'];
        //                 }
        //                 $lastNameValid = checkValidName($data['lastName']);
        //                 if(!$lastNameValid['result']){
        //                     $data['lastNameError'] = $lastNameValid['error'];
        //                 }

        //                 // Validate email
        //                 $emailValid = checkValidEmail($data['email']);
        //                 if(!$emailValid['result']){
        //                     $data['emailError'] = $emailValid['error'];
        //                 }
        //                 else{
        //                     //Check if email exists.
        //                     if ($this->userModel->findUserByEmail($data['email'])) {
        //                         $data['emailError'] = 'Email is already registered.';
        //                     }
        //                 }


        //                 if(empty($data['firstNameError']) && empty($data['lastNameError']) && empty($data['emailError'])){
        //                     //Update user from model function
        //                     if ($this->userModel->updateUser($data)) {
        //                         $data['result'] = true;
        //                         echo json_encode($data);
        //                     } else {
        //                         die('Something went wrong.');
        //                     }
        //                 }else{
        //                     echo json_encode($data);
        //                 }
                        

        //             }
        //         }
        //     }else{
        //         $this->logout();
        //     }
        // }


        public function updateUserProfile() {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);

                    $data = [
                        'picture_id' => (int)trim($_POST['picture_id']),
                        'background_id' => (int)trim($_POST['background_id']),
                        'nickname' => trim($_POST['nickname']),
                        'description' => trim($_POST['description']),
                        'user_id' => $_SESSION['user_id']
                    ];

                    // echo "<pre>";
                    // var_dump($data);
                    // echo "</pre>";

                    $result = $this->userModel->updateUserProfile($data);
                    echo json_encode($result);

            }
        }


        public function follow(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);

                    $data = [
                        'follower_id' => trim($_POST['user_id']),
                        'user_id' => $_SESSION['user_id']
                    ];
                    $result = $this->userModel->follow($data['follower_id'], $data['user_id']);

                    $notification_data = [
                        'type' => "follow",
                        'sender_id' => $data['user_id'],
                        'receiver_id' => $data['follower_id'],
                    ];
                    $this->notificationModel->saveNotification($notification_data);

                    echo json_encode($result);

            }
        }

        public function unfollow(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST);

                    $data = [
                        'follower_id' => trim($_POST['user_id']),
                        'user_id' => $_SESSION['user_id']
                    ];
                    $result = $this->userModel->unfollow($data['follower_id'], $data['user_id']);
                    

                    echo json_encode($result);

            }
        }
        // ---------------------- //
        // DELETE USER            //
        // ---------------------- //
        public function deleteUser(){
            if(isLoggedIn()){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    //Sanitize post data
                    $_POST = filter_input_array(INPUT_POST);

                    if(isset($_POST['delete_row']))
                    {
                        $data = [
                            'id' => trim($_POST['id']),
                            'result' => false,
                            'error' => ''
                        ];

                        if($this->userModel->deleteUser($data['id'])){
                            $data['result'] = true;
                            echo json_encode($data);
                        }else{
                            $data['error'] = 'Could not delete user';
                            echo json_encode($data);
                        }
                    }
                }
            }else{
                $this->logout();
            }
        }


        // ---------------------- //
        // LOGOUT                 //
        // ---------------------- //

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['email']);
            unset($_SESSION['LAST_ACTIVITY']);

            header('location:' . URLROOT);
        }



        public function getuserlist(){
            $data = [
                'result' => false,
                'user_id' => $_SESSION['user_id'],
                'mention' => trim($_POST['mention']),
            ];

            // Get all hashtags that include provided substring
            $result = $this->userModel->getUsersBySubstring($data['mention']);
            echo json_encode($result);
        }


    }



    