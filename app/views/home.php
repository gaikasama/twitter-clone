<?php require APPROOT . '/views/inc/head.php'?>

<div class="row g-0 height--xxl">

    <?php require APPROOT . '/views/inc/navigation.php'?>


    <!-- Feed -->
    <div class="col-6 border--left-right" style="position: relative;">


        <?php require APPROOT . '/views/inc/top.php'?>
        <?php require APPROOT . '/views/inc/top_tweet.php'?>
        <?php require APPROOT . '/views/inc/feed.php'?>

    </div>
    <?php require APPROOT . '/views/popup/tweet.php'?>


    <!-- Search -->
    <div class="col-3">
    <?php require APPROOT . '/views/inc/search.php'?>

    </div>
</div>