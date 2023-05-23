<?php require APPROOT . '/views/inc/head.php'?>

<div class="row g-0 height--xxl">

    <?php require APPROOT . '/views/inc/navigation.php'?>



    <!-- Feed -->
    <div class="col-6 border--left-right" style="position: relative;">

        <div class="d-inline-flex w-100 justify-content-start align-items-center px-2 py-3">
            <div class="">
                <a href="<?php echo URLROOT; ?>/tweets/home">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="" width="20" height="20">
                        <g>
                            <path
                                d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z">
                            </path>
                        </g>
                    </svg>
                </a>
            </div>
            <div class="position--sticky opacity--strong background--white p-3 fw-bold fs-5">
                <span class="navbar-brand pointer--cursor" onclick="topFunction()"><?php echo $data['title']?></span>
                <div>
                    <span class="fw-light text--s color--gray">
                        <?php echo $data['tweet_count']?> Tweets
                    </span>
                </div>
            </div>

        </div>

        <!-- USER INFO -->
        <div class="w-100">
            <!-- top section with pictures -->
            <div class="position-relative">
                <div class="display-flex w-100 position-relative">
                    <!-- background picture -->
                    
                    <div class="<?php echo $data['background'] ? 'background--white' : 'background--super-light-gray'?>" style="height: 200px;">
                        <?php if($data['avatar']):?>
                            <img src="<?php echo URLROOT; ?>/public/assets/profile/background/<?php echo $data['background']["picture_name"]?>" alt="" class="img">
                        <?php endif?>
                    </div>
                    


                    <div class="position-absolute z--index" style="left: 10px; bottom: -40px; ">
                            <div class="width--tweet-img ">
                                <?php if($data['avatar']):?>
                                    <div class="new--dot img--wrap">
                                        <img src="<?php echo URLROOT; ?>/public/assets/profile/avatar/<?php echo $data['avatar']["picture_name"]?>" alt="" class="img">
                                    </div>
                                <?php else :?>
                                <span class="new--dot"></span>
                                <?php endif;?>
                            </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-end p-3">

                    <?php if($_SESSION['user_id'] === (int)$data['user_id']):?>
                        
                            <div
                                class=" px-3 py-1 rounded-pill border pointer--cursor" id="followBtn" data-bs-toggle="modal" data-bs-target="#editProfile">
                                <span class="fw-bold color--black">
                                    Edit profile

                                </span>
                            </div>
                    <?php else:?>
                        <div onclick="unfollow(<?php echo $data['user_id']?>)" class="border px-3 py-1 rounded-pill"
                            id="unfollowBtn" style="display: <?php echo $data['user_following'] ? 'block' : 'none'?>">

                        </div>
                        <div onclick="follow(<?php echo $data['user_id']?>)"
                            class="background--black px-3 py-1 rounded-pill" id="followBtn"
                            style="display: <?php echo $data['user_following'] ? 'none' : 'block'?>">
                            <span class="fw-bold color--white">
                                Follow

                            </span>
                        </div>
                    <?php endif;?>

                    



                </div>

                <div class="p-3">
                    <div>
                        <p class="m-0 fw-bold">
                            <?php echo $data['user_info']['nickname']?>
                        </p>
                        <p class="m-0 text--s text--gray">
                            @<?php echo $data['user_info']['username']?>
                        </p>
                        <?php if($data['user_info']['description']):?>
                        <p class="m-0 mt-3">
                            <?php echo $data['user_info']['description']?>
                        </p>
                        <?php endif?>
                    </div>

                </div>
            </div>
        </div>


        <?php require APPROOT . '/views/inc/feed.php'?>

    </div>
    <?php require APPROOT . '/views/popup/tweet.php'?>


    <!-- Search -->
    <div class="col-3">
        <?php require APPROOT . '/views/inc/search.php'?>

    </div>
</div>

<?php require APPROOT . '/views/popup/editprofile.php'?>