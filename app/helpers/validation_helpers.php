<?php
// Validate email
function checkValidEmail($email){

    $data = [
        'result' => false,
        'error' => ''
    ];

    if(empty($email)){
        $data['error'] = 'This field cannot be empty'; 
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $data['error'] = 'Please enter valid email'; 
    }else{
        $data['result'] = true;
    }
    return $data;
 }

//  Check if inputs are empty
 function checkEmptyInputs($arr){
    $data = [
        'result' => false,
        'errors' => []
    ];

    foreach($arr as $key => $val){
        if(empty($val)){

            $data['errors'][$key . 'Error'] = 'Please enter ' . $key;
        }
    }
    if(count($data['errors']) == 0){
        $data['result'] = true;
    }

    return $data;
 }


//  Validate name
function checkValidName($name){
    $data = [
        'result' => false,
        'error' => ''
    ];

    if(empty($name)){
        $data['error'] = 'This field cannot be empty'; 
    }elseif(!preg_match("/^[a-zA-Z0-9]*$/", $name)){
        $data['error'] = 'Please enter valid name'; 
    }else{
        $data['result'] = true;
    }
    return $data;
 }

//  Validate password
 function checkValidPassword($password){
    $data = [
        'result' => false,
        'error' => ''
    ];

    if(empty($password)){
        $data['error'] = 'This field cannot be empty';
      } elseif(strlen($password) < 6){
        $data['error'] = 'Password must be at least 8 characters';
      }elseif (preg_match("/^(.{0,7}|[^a-z]*|[^\d]*)$/i", $password)) {
        $data['error'] = 'Password must be have at least one numeric value.';
      }else{
          $data['result'] = true;
      }

      return $data;
 }

//  Validate confirm password
 function checkPasswords($password, $confirmPassword){
    $data = [
        'result' => false,
        'error' => ''
    ];

    if (empty($confirmPassword)) {
        $data['error'] = 'Please enter confirm password.';
    } elseif ($password != $confirmPassword) {
        $data['error'] = 'Passwords do not match, please try again.';
    }else{
        $data['result'] = true;
    }
    return $data;
}