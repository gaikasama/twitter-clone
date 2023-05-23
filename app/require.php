<?php
    // Require libraries from library folder
    require_once "libraries/Core.php";
    require_once "libraries/Controller.php";
    require_once "libraries/Database.php";

    require_once "config/db_connection.php";

    require_once "helpers/helpers.php";
    require_once "helpers/validation_helpers.php";
    require_once 'helpers/session_helper.php';
    
    // Instantiate core class
    $init = new Core();