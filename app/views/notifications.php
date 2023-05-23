<?php require APPROOT . '/views/inc/head.php'?>

<div class="row g-0 height--xxl">

    <?php require APPROOT . '/views/inc/navigation.php'?>


    <!-- Feed -->
    <div class="col-6 border--left-right" style="position: relative;">


        <?php require APPROOT . '/views/inc/top.php'?>
        <div class="list-group w-100">

            <?php foreach ($data['notifications'] as $tweet) :?>

            <!-- <pre>
                    <?php var_dump($tweet); ?>

                </pre> -->
            <section
                class="list-group-item list-group-item-action border--top-bottom d-flex flex-wrap w-100 justify-content-between"
                aria-current="true" id="tweet<?php echo $tweet['id']?>">

                <div class="me-3 width--tweet-img">
                    <?php if($tweet['type'] === 'retweet'):?>
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="fill--gray fill--green" width="30" height="30">
                        <g>
                            <path
                                d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z">
                            </path>
                        </g>
                    </svg>

                    <?php elseif($tweet['type'] === 'like'):?>
                    <svg viewBox="0 0 24 24" aria-hidden="true" width="30" height="30" class="fill--pink">
                        <g>
                            <path
                                d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12z">
                            </path>
                        </g>
                    </svg>
                    <?php elseif($tweet['type'] === 'follow'):?>
                    <svg viewBox="0 0 24 24" aria-hidden="true" width="30" height="30" class="fill--blue">
                        <g>
                            <path
                                d="M12.225 12.165c-1.356 0-2.872-.15-3.84-1.256-.814-.93-1.077-2.368-.805-4.392.38-2.826 2.116-4.513 4.646-4.513s4.267 1.687 4.646 4.513c.272 2.024.008 3.46-.806 4.392-.97 1.106-2.485 1.255-3.84 1.255zm5.849 9.85H6.376c-.663 0-1.25-.28-1.65-.786-.422-.534-.576-1.27-.41-1.968.834-3.53 4.086-5.997 7.908-5.997s7.074 2.466 7.91 5.997c.164.698.01 1.434-.412 1.967-.4.505-.985.785-1.648.785z">
                            </path>
                        </g>
                    </svg>
                    <?php else:?>
                    <a href="">
                        <span class="dot"></span>
                    </a>
                    <?php endif;?>
                </div>

                <div class="width--tweet-content">
                    <?php if($tweet['type'] === 'retweet'):?>
                        <div class="dot dot--s">
                            <?php if($tweet['avatar']):?>
                                <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $tweet['avatar']["picture_name"]?>"
                                alt="" class="img">
                            <?php else:?>
                                <span class="dot dot--s"></span>
                            <?php endif;?>
                            
                        </div>
                        <div>
                            <span class="fw-bold"><?php echo $tweet['user_info']['nickname']?></span> retweeted your tweet
                        </div>
                        <!-- <?php echo $tweet['user_info']['nickname']?> -->

                    <?php elseif($tweet['type'] === 'like'):?>
                    <div class="dot dot--s">
                        <?php if($tweet['avatar']):?>
                        <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $tweet['avatar']["picture_name"]?>"
                            alt="" class="img">
                        <?php else:?>
                        <span class="dot dot--s"></span>
                        <?php endif;?>
                    </div>
                    <div>
                        <span class="fw-bold"><?php echo $tweet['user_info']['nickname']?></span> liked your
                        <?php echo $tweet['tweet_type']?>
                    </div>

                    
                    <?php elseif($tweet['type'] === 'follow'):?>
                    <div class="dot dot--s">
                        <?php if($tweet['avatar']):?>
                            <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $tweet['avatar']["picture_name"]?>"
                            alt="" class="img">
                        <?php else:?>
                            <span class="dot dot--s"></span>
                        <?php endif;?>
                        
                    </div>
                    <div>
                            <span class="fw-bold"><?php echo $tweet['user_info']['nickname']?></span> followed you
                        </div>
                    <?php else:?>

                    <?php endif;?>
                </div>

            </section>
            <?php endforeach;?>

        </div>

    </div>


    <!-- Search -->
    <div class="col-3">
        <?php require APPROOT . '/views/inc/search.php'?>

    </div>
</div>