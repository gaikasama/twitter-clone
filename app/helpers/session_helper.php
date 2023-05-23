<?php
    session_start();

    // Create User Session
    function createUserSession($user) {

        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['LAST_ACTIVITY'] = time();

        // header('location:' . URLROOT . '/tweets/home');
    }

    // Check if user is logged in 
    function isLoggedIn() {
        if(isset($_SESSION['user_id']) && (time() - $_SESSION['LAST_ACTIVITY'] < 1800)){
            $_SESSION['LAST_ACTIVITY'] = time();
            return true;
        }else{
            return false;
        }
}
    
    