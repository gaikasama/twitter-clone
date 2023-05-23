<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta htttp-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?php echo SITENAME; ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo URLROOT ?>/public/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URLROOT ?>/public/assets/favicon//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo URLROOT ?>/public/assets/favicon//favicon-16x16.png">
    <link rel="manifest" href="<?php echo URLROOT ?>/public/assets/favicon//site.webmanifest">
    <link rel="mask-icon" href="<?php echo URLROOT ?>/public/assets/favicon//safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo URLROOT ?>/public/css/style.css?=1">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="<?php echo URLROOT ?>/public/javascript/home.js"></script>
    <script src="<?php echo URLROOT ?>/public/javascript/validation.js"></script>
    <script src="<?php echo URLROOT ?>/public/javascript/login.js"></script>
    <script src="<?php echo URLROOT ?>/public/javascript/helpers.js"></script>

    <script src="<?php echo URLROOT ?>/public/javascript/feed.js"></script>
    <script src="<?php echo URLROOT ?>/public/javascript/notification.js"></script>
</head>




    <body class="container-xl g-0">


<!-- <header class="header">
    <div class="header__title">
        <h1 class="header__title-text <?php if(!isset($_SESSION['user_id'])) echo 'header__title-text--white'?>"><?php echo SITENAME?></h1>
    </div>

    <div class="header__navigation">

            <?php if(isset($_SESSION['user_id'])) : ?>
            <div  class="header__navigation-item">
                <a href="<?php echo URLROOT; ?>/users/logout" class=" button button--gray button--round">Log out</a>
            </div>
            <?php endif; ?>
            <div  class="header__navigation-item">
                <?php if(!isset($_SESSION['user_id'])) : ?>
                    <?php if($data['title'] == 'Login page') : ?>
                        <a href="<?php echo URLROOT ?>" class="button button--round">Sign Up</a>
                    <?php else : ?>
                        <a href="<?php echo URLROOT ?>/users/login" class="button button--round">Login</a>
                    <?php endif; ?>
                <?php endif; ?>

                    </div>
    </div>

</header> -->


