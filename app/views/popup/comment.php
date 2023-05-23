<div class="modal fade" id="commentPopup<?php echo $tweet['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-wrap w-100">
                    <!-- users picture -->
                    <div class="me-3">
                        <span class="dot"></span>
                    </div>

                    <div class="flex-fill width--tweet-content">

                        <!-- USER INFO -->
                        <div class="d-flex w-100 justify-content-start">
                            <!-- Tweet user info -->
                            <?php if( $tweet['tweet_type'] === "comment_retweet" ):?>
                            <div class="d-flex w-100 justify-content-start">
                                <span class="fw-bold">
                                    <?php echo $tweet['user_info']["nickname"]?>
                                </span>
                                <span class="text--gray px-2">@<?php echo $tweet['user_info']["username"] ?> ・
                                    <?php echo $tweet['retweet_comment_content']['created'] ?></span>
                            </div>
                            <?php elseif($tweet['tweet_type'] === "retweet"  && $tweet['origin_tweet_type'] === "comment_retweet"):?>
                            <div class="d-flex w-100 justify-content-start">
                                <span class="fw-bold">
                                    <?php echo $tweet['retweet_comment_user_info']["nickname"]?>
                                </span>
                                <span
                                    class="text--gray px-2">@<?php echo $tweet['retweet_comment_user_info']["username"] ?>
                                    ・
                                    <?php echo $tweet['retweet_comment_content']['created'] ?></span>
                            </div>
                            <?php elseif($tweet['tweet_type'] === "retweet"):?>
                            <div class="d-flex w-100 justify-content-start">
                                <span class="fw-bold">
                                    <?php echo $tweet['origin_user_info']["nickname"]?>
                                </span>
                                <span class="text--gray px-2">@<?php echo $tweet['origin_user_info']["username"] ?> ・
                                    <?php echo $tweet['content']['created'] ?></span>
                            </div>

                            <?php else:?>
                            <div class="d-flex w-100 justify-content-start">
                                <span class="fw-bold">
                                    <?php echo $tweet['user_info']["nickname"]?>
                                </span>
                                <span class="text--gray px-2">@<?php echo $tweet['user_info']["username"] ?> ・
                                    <?php echo $tweet['content']['created'] ?></span>
                            </div>
                            <?php endif;?>
                        </div>


                        <!-- TWEET CONTENT -->
                        <div class="">
                            <!-- commented retweet -->
                            <?php if($tweet['tweet_type'] === "comment_retweet"):?>
                            <span
                                class="mb-1 text-break"><?php echo $tweet['retweet_comment_content']['content']?></span>
                            <div class="border rounded rounded-3 p-2 mt-2">
                                <div>
                                    <span class="fw-bold">
                                        <?php echo $tweet['origin_tweet_user_info']["nickname"]?>
                                    </span>
                                    <span
                                        class="text--gray px-2">@<?php echo $tweet['origin_tweet_user_info']["username"] ?>
                                        ・
                                        <?php echo $tweet['origin_tweet_content']['created'] ?></span>
                                </div>
                                <div>
                                    <?php if($tweet['origin_tweet_type'] === 'comment_retweet' || $tweet['origin_tweet_type'] === 'retweet') :?>
                                    <span class="text-break">
                                        <?php echo URLROOT; ?>/tweets/tweet/<?php echo $tweet['retweet_comment_content']['origin_tweet_id']?></span>
                                    <?php else:?>
                                    <span
                                        class="text-break"><?php echo $tweet['origin_tweet_content']['content']?></span>

                                    <?php endif;?>

                                </div>

                            </div>


                            <!-- retweet -->
                            <?php elseif($tweet['tweet_type'] === "retweet") :?>

                            <?php if($tweet['origin_tweet_type'] === 'comment_retweet'):?>
                            <span
                                class="mb-1 text-break"><?php echo $tweet['retweet_comment_content']['content']?></span>

                            <div class="border rounded rounded-3 p-2 mt-2">
                                <div>
                                    <span class="fw-bold">
                                        <?php echo $tweet['origin_tweet_user_info']["nickname"]?>
                                    </span>
                                    <span
                                        class="text--gray px-2">@<?php echo $tweet['origin_tweet_user_info']["username"] ?>
                                        ・
                                        <?php echo $tweet['origin_tweet_content']['created'] ?></span>
                                </div>
                                <div>
                                    <span
                                        class="text-break"><?php echo $tweet['origin_tweet_content']['content']?></span>
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

                    </div>
                </div>

                <!-- COMMENT AREA -->
                <div class="d-flex flex-row flex-wrap justify-content-between mt-3">
                    <div class="me-3">
                        <span class="dot"></span>
                    </div>
                    <div class="flex-fill width--tweet-content">
                        <form action="<?php echo URLROOT; ?>/tweets/comment" method="POST" id="comment<?php echo $tweet['id']?>">
                            <!-- <input type="hidden" name="type" value="comment"> -->
                            <!-- <input type="hidden" name="tweet_id" value="<?php echo $tweet['id'];?>"> -->
                            <!-- <div>
                            <input class="form-control form-control-lg border--none" name="comment" type="text"
                                placeholder="Add a comment" aria-label=".form-control-lg example">
                        </div> -->
                            <div contenteditable="true" class="required tweetContent comment" id="comment<?php echo $tweet['id']?>"
                                name="content" onkeydown="textAreaAdjust(this)"
                                onkeyup="enableTweetSubmit('comment<?php echo $tweet['id']?>',this)">

                            </div>
                            <div id="comment<?php echo $tweet['id']?>UploadedImagesBox"
                                class="w-100 d-flex flex-row flex-wrap justify-content-between">

                            </div>
                            <div class="d-flex flex-row justify-content-between mt-3 w-100">
                                <div class="w-50 d-flex flex-row">
                                    <input type="hidden" name="image" id='commentImage1' value=''>
                                    <input type="hidden" name="image" id='commentImage2' value=''>
                                    <input type="hidden" name="image" id='commentImage3' value=''>
                                    <input type="hidden" name="image" id='commentImage4' value=''>
                                    <label for="commentUploadImage" class="position-relative w-100">
                                        <input type="file" id="commentUploadImage" class="w-25" name="file"
                                            style="opacity: 0; z-index:-1; position:absolute"
                                            onchange="imageUpload('comment<?php echo $tweet['id']?>')">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" width="20" height="20"
                                            class="fill--blue pointer--cursor">
                                            <g>
                                                <path
                                                    d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z">
                                                </path>
                                                <circle cx="8.868" cy="8.309" r="1.542"></circle>
                                            </g>
                                        </svg>
                                    </label>
                                </div>

                                <div class="d-flex flex-row align-items-center">
                                    <div class="circle-wrap me-2">
                                        <svg width="30" height="30">
                                            <circle r="10" cx="15" cy="15" class="track"></circle>
                                            <circle r="10" cx="15" cy="15" class="progress"></circle>
                                        </svg>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary rounded-pill background--blue border--blue"
                                        onclick="postComment(event, <?php echo $tweet['id']?>, <?php echo $tweet['tweet_type'] === 'retweet' ? $tweet['retweet']['origin_tweet_id'] : $tweet['id']?>, 'comment<?php echo $tweet['id']?>')"
                                        disabled>Comment</button>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="position-absolute background--white rounded bottom--negative" id='comment<?php echo $tweet['id']?>Hashtagbox'
                        style="display: none;">

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>