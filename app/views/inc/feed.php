<div class="list-group w-100">

    <?php foreach ($data['feed'] as $tweet) :?>
    <section
        class="list-group-item list-group-item-action border--top-bottom d-flex flex-wrap w-100 justify-content-between"
        aria-current="true" id="tweet<?php echo $tweet['id']?>" onclick="tweetDetails(<?php echo $tweet['id']?>)">

        <?php if($tweet['tweet_type'] === "retweet"):?>


        <div class="w-100 d-flex mb-1 justify-content-between">
            <div class="width--tweet-img me-3 d-flex align-self-center justify-content-end">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="fill--gray" width="16" height="16">
                    <g>
                        <path
                            d="M23.615 15.477c-.47-.47-1.23-.47-1.697 0l-1.326 1.326V7.4c0-2.178-1.772-3.95-3.95-3.95h-5.2c-.663 0-1.2.538-1.2 1.2s.537 1.2 1.2 1.2h5.2c.854 0 1.55.695 1.55 1.55v9.403l-1.326-1.326c-.47-.47-1.23-.47-1.697 0s-.47 1.23 0 1.697l3.374 3.375c.234.233.542.35.85.35s.613-.116.848-.35l3.375-3.376c.467-.47.467-1.23-.002-1.697zM12.562 18.5h-5.2c-.854 0-1.55-.695-1.55-1.55V7.547l1.326 1.326c.234.235.542.352.848.352s.614-.117.85-.352c.468-.47.468-1.23 0-1.697L5.46 3.8c-.47-.468-1.23-.468-1.697 0L.388 7.177c-.47.47-.47 1.23 0 1.697s1.23.47 1.697 0L3.41 7.547v9.403c0 2.178 1.773 3.95 3.95 3.95h5.2c.664 0 1.2-.538 1.2-1.2s-.535-1.2-1.198-1.2z">
                        </path>
                    </g>
                </svg>
            </div>
            <div class="width--tweet-content">
                <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['user_info']['id']?>">
                    <span class="fw-bold text--gray text--xs">
                        <?php echo $tweet['user_info']["nickname"]?></span>
                </a>
                <span class="fw-bold text--gray text--xs"> Retweeted</span>

            </div>
        </div>

        <?php endif;?>

        <!-- users picture -->
        <div class="me-3 width--tweet-img">

            <?php if($tweet['tweet_type'] === "retweet"  && $tweet['origin_tweet_type'] === "comment_retweet"):?>
            <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['retweet_comment_user_info']['id']?>">
                <?php if($tweet['avatar']):?>
                <div class="dot">

                    <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $tweet['avatar']["picture_name"]?>"
                        alt="" class="img">
                </div>
                <?php else:?>
                <span class="dot"></span>
                <?php endif;?>
            </a>
            <?php elseif($tweet['tweet_type'] === "retweet"):?>
            <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_user_info']['id']?>">
                <?php if($tweet['avatar']):?>
                <div class="dot">

                    <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $tweet['avatar']["picture_name"]?>"
                        alt="" class="img">
                </div>
                <?php else:?>
                <span class="dot"></span>
                <?php endif;?>
            </a>
            <?php else:?>
            <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['user_info']['id']?>">
                <?php if($tweet['avatar']):?>
                <div class="dot">

                    <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $tweet['avatar']["picture_name"]?>"
                        alt="" class="img">
                </div>
                <?php else:?>
                <span class="dot"></span>
                <?php endif;?>
            </a>
            <?php endif?>

        </div>

        <div class="width--tweet-content">
            <!-- Tweet user info -->

            <!-- Comment retweet user -->
            <?php if( $tweet['tweet_type'] === "comment_retweet" ):?>
            <div class="d-flex flex-wrap w-100 justify-content-start">

                <span class="fw-bold">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['user_info']['id']?>">
                        <?php echo $tweet['user_info']["nickname"]?>
                    </a>
                </span>
                <span class=" px-2">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['user_info']['id']?>"
                        class="text--gray">
                        @<?php echo $tweet['user_info']["username"] ?>
                    </a>
                </span>
                <span class="text--gray px-2"> ・ <?php echo $tweet['retweet_comment_content']['created'] ?></span>
            </div>

            <!-- Comment retweet retweet's user -->
            <?php elseif($tweet['tweet_type'] === "retweet"  && $tweet['origin_tweet_type'] === "comment_retweet"):?>
            <div class="d-flex flex-wrap w-100 justify-content-start">
                <span class="fw-bold">
                    <a
                        href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['retweet_comment_user_info']['id']?>">
                        <?php echo $tweet['retweet_comment_user_info']["nickname"]?>
                    </a>
                </span>
                <span class="px-2">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['retweet_comment_user_info']['id']?>"
                        class="text--gray">
                        @<?php echo $tweet['retweet_comment_user_info']["username"] ?>
                    </a>
                </span>
                <span class="text--gray px-2"> ・ <?php echo $tweet['retweet_comment_content']['created'] ?></span>
            </div>
            <!-- <?php var_dump($tweet)?> -->

            <!-- Retweet user -->
            <?php elseif($tweet['tweet_type'] === "retweet"):?>
            <div class="d-flex flex-wrap w-100 justify-content-start">
                <span class="fw-bold">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_user_info']['id']?>">
                        <?php echo $tweet['origin_user_info']["nickname"]?>
                    </a>
                </span>
                <span class="px-2">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_user_info']['id']?>"
                        class="text--gray">
                        @<?php echo $tweet['origin_user_info']["username"] ?>
                    </a>
                </span>
                <span class="text--gray px-2"> ・
                    <?php echo $tweet['content']['created'] ?></span>
            </div>

            <!-- Tweet user -->
            <?php else:?>
            <div class="d-flex flex-wrap w-100 justify-content-start">
                <span class="fw-bold">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['user_info']['id']?>">
                        <?php echo $tweet['user_info']["nickname"]?>
                    </a>
                </span>

                <span class="px-2">
                    <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['user_info']['id']?>"
                        class="text--gray">
                        @<?php echo $tweet['user_info']["username"] ?>
                    </a></span>
                <span class="text--gray px-2"> ・ <?php echo $tweet['content']['created'] ?></span>
            </div>
            <?php endif;?>


            <!-- Tweet content -->
            <div class="">
                <!-- commented retweet -->
                <?php if($tweet['tweet_type'] === "comment_retweet"):?>
                <span class="mb-1 text-break"><?php echo $tweet['retweet_comment_content']['content']?></span>
                <div class="border rounded rounded-3 p-2 mt-2">
                    <div>
                        <span class="fw-bold">
                            <a
                                href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_tweet_user_info']['id']?>">
                                <?php echo $tweet['origin_tweet_user_info']["nickname"]?>
                            </a>
                        </span>
                        <span class=" px-2">
                            <a href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_tweet_user_info']['id']?>"
                                class="text--gray">
                                @<?php echo $tweet['origin_tweet_user_info']["username"] ?>
                            </a>
                        </span><span class="text--gray px-2"> ・
                            <?php echo $tweet['origin_tweet_content']['created'] ?></span>
                    </div>
                    <div>
                        <?php if($tweet['origin_tweet_type'] === 'comment_retweet' || $tweet['origin_tweet_type'] === 'retweet') :?>
                        <span class="text-break">
                            <?php echo URLROOT; ?>/tweets/tweet/<?php echo $tweet['retweet_comment_content']['origin_tweet_id']?></span>
                        <?php else:?>
                        <span class="text-break"><?php echo $tweet['origin_tweet_content']['content']?></span>

                        <?php endif;?>

                    </div>

                </div>


                <!-- retweet -->
                <?php elseif($tweet['tweet_type'] === "retweet") :?>

                <?php if($tweet['origin_tweet_type'] === 'comment_retweet'):?>
                <span class="mb-1 text-break"><?php echo $tweet['retweet_comment_content']['content']?></span>

                <div class="border rounded rounded-3 p-2 mt-2">
                    <div>
                        <span class="fw-bold">
                            <a
                                href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_tweet_user_info']['id']?>">
                                <?php echo $tweet['origin_tweet_user_info']["nickname"]?>
                            </a>
                        </span>
                        <span class="px-2">
                            <a
                                href="<?php echo URLROOT;?>/tweets/profile/<?php echo $tweet['origin_tweet_user_info']['id']?>">
                                @<?php echo $tweet['origin_tweet_user_info']["username"] ?>
                            </a>
                        </span>
                        <span class="text--gray px-2"> ・
                            <?php echo $tweet['origin_tweet_content']['created'] ?>
                        </span>
                    </div>
                    <div>
                        <span class="text-break"><?php echo $tweet['origin_tweet_content']['content']?></span>
                    </div>

                </div>

                <?php else:?>
                <span class="mb-1 text-break"><?php echo $tweet['content']['content']?></span>

                <?php endif;?>


                <!-- tweet -->

                <?php else:?>
                <span class="mb-1 text-break"><?php echo $tweet['content']['content']?></span>

                <?php endif;?>

                <?php if($tweet['pictures']):?>
                <div class="w-100 d-flex flex-row flex-wrap justify-content-betweet">
                    <?php foreach($tweet['pictures'] as $picture):?>
                    <div class="image-width--m m-1 rounded overflow--hidden"
                        style="width: calc(90% / <?php echo count($tweet['pictures'])?>)">
                        <img src="<?php echo URLROOT; ?>/public/assets/tweet/<?php echo $picture["picture_name"]?>"
                            class="w-100" alt="">
                    </div>
                    <?php endforeach;?>
                </div>

                <?php endif;?>


            </div>


            <!-- Action row (comment, tweet, retweet) -->
            <div class="mt-3 d-flex flex-wrap justify-content-between w-100 ">

                <!-- Comment -->
                <div class="d-flex flex-wrap flex-fill " data-bs-toggle="modal"
                    data-bs-target="#commentPopup<?php echo $tweet['id'];?>" onclick="preventDefault(event)">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="fill--gray" width="18">
                        <g>
                            <path
                                d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z">
                            </path>
                        </g>
                    </svg>
                    <span class="text--gray ms-3 text--s">
                        <?php if($tweet['comment_count'] > 0):?>
                        <?php echo $tweet['comment_count']?>
                        <?php endif;?>
                    </span>
                </div>

                <!-- Retweet -->
                <div class="d-flex flex-wrap flex-fill position-relative"
                    onclick="openPrompt(event, <?php echo ($tweet['tweet_type'] === 'retweet' ? $tweet['retweet']['origin_tweet_id'] : $tweet['id'])?>, <?php echo $tweet['id']?>)">
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
                    <div onclick="like(event, <?php echo $tweet['id']?>, <?php echo ($tweet['tweet_type'] === 'retweet' ? $tweet['retweet']['origin_tweet_id'] : $tweet['id'])?>)"
                        class="text--gray <?php if($tweet['user_like']) echo 'text--pink'?>"
                        id="like<?php echo $tweet['id']?>">

                        <i
                            class="bi text--gray <?php echo $tweet['user_like'] ? 'text--pink bi-heart-fill' : 'bi-heart'?>"></i>

                        <span class="text--gray ms-3 text--s <?php if($tweet['user_like']) echo 'text--pink'?>">
                            <?php if($tweet['like_count'] > 0):?>
                            <?php echo $tweet['like_count']?>
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

    </section>
    <?php require APPROOT . '/views/popup/retweet.php'?>
    <?php require APPROOT . '/views/popup/comment.php'?>

    <?php endforeach;?>
</div>