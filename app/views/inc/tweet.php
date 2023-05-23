<div class="list-group w-100">

    <?php require APPROOT . '/views/inc/feed.php'?>

    <?php foreach($data['comments'] as $comment):?>
    <div
        class="list-group-item list-group-item-action border--top-bottom d-flex flex-wrap w-100 justify-content-between">
        <div class="me-3 width--tweet-img">
            <span class="dot"></span>
        </div>

        <div class="width--tweet-content">
            <div class="d-flex flex-wrap w-100 justify-content-start">
                <span class="fw-bold">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $comment['user_info']['id']?>">
                        <?php echo $comment['user_info']["nickname"]?>
                    </a>
                </span>
                <span class="px-2">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $comment['user_info']['id']?>" class="text--gray">
                        @<?php echo $comment['user_info']["username"] ?>
                    </a>
                </span>
                <span class="text--gray px-2"> ・
                    <?php echo $comment['created'] ?>
                </span>
            </div>
            <div class="">
                <span><?php echo $comment['content'] ?></span></span>
            </div>

            <!-- Action row (comment, tweet, retweet) -->
            <div class="mt-3 d-flex flex-wrap justify-content-between w-100 ">

                <!-- Comment -->
                <div class="d-flex flex-wrap flex-fill " data-bs-toggle="modal"
                    data-bs-target="#commentPopup<?php echo $comment['tweet_id'];?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="fill--gray" width="18">
                        <g>
                            <path
                                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z">
                            </path>
                        </g>
                    </svg>
                    <span class="text--gray ms-3 text--s">
                        <!-- <?php if($tweet['comment_count'] > 0):?>
                        <?php echo $tweet['comment_count']?>
                        <?php endif;?> -->
                    </span>
                </div>

                <!-- Retweet -->
                <div class="d-flex flex-wrap flex-fill position-relative"
                    onclick="openPrompt(event, <?php echo ($tweet['tweet_type'] === 'retweet' ? $tweet['origin_tweet_id'] : $tweet['id'])?>, <?php echo $tweet['id']?>)">
                    <svg viewBox="0 0 24 24" aria-hidden="true"
                        class="fill--gray <?php if($tweet['user_retweet']) echo 'fill--green'?>" width="18" height="18"
                        id="retweetIcon<?php echo $tweet['id']?>">
                        <g>
                            <path
                                d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z">
                            </path>
                        </g>
                    </svg>
                    <span
                        class="text--gray ms-3 text--s text-center <?php if($tweet['user_retweet']) echo 'text--green'?>"
                        id="retweetCount<?php echo $tweet['id']?>">
                        <?php if($tweet['retweet_count'] > 0):?>
                        <?php echo $tweet['retweet_count']?>
                        <?php endif;?>
                    </span>
                    <div>
                        <?php require APPROOT . '/views/popup/retweet_prompt.php'?>

                    </div>

                </div>



                <!-- Like -->
                <div class="d-flex flex-wrap flex-fill">
                    <div onclick="like(event, <?php echo $comment['tweet_id']?>)"
                        class="text--gray <?php if($comment['user_like']) echo 'text--pink'?>"
                        id="like<?php echo $comment['tweet_id']?>">

                        <i
                            class="bi text--gray <?php echo $comment['user_like'] ? 'text--pink bi-heart-fill' : 'bi-heart'?>"></i>

                        <span class="text--gray ms-3 text--s <?php if($comment['user_like']) echo 'text--pink'?>">
                            <?php if($comment['like_count'] > 0):?>
                            <?php echo $comment['like_count']?>
                            <?php endif;?>
                        </span>
                    </div>

                </div>

                <!-- Share -->
                <div class="d-flex flex-wrap flex-fill">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="fill--gray" width="18">
                        <g>
                            <path
                                d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06s.767.294 1.06 0l3.72-3.72V15c0 .414.336.75.75.75s.75-.336.75-.75V4.81l3.72 3.72c.146.147.338.22.53.22s.384-.072.53-.22c.293-.293.293-.767 0-1.06z">
                            </path>
                            <path
                                d="M19.708 21.944H4.292C3.028 21.944 2 20.916 2 19.652V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 1.264-1.028 2.292-2.292 2.292z">
                            </path>
                        </g>
                    </svg>
                </div>

            </div>

        </div>



    </div>

    <?php endforeach;?>
</div>