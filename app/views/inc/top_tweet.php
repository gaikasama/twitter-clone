<div class="p-3 d-flex justify-content-between">
    <div class="me-3 width--tweet-img">
        <?php if($data['avatar']):?>
        <div class="dot">
            <img src="<?php echo URLROOT;?>/public/assets/profile/avatar/<?php echo $data['avatar']["picture_name"]?>"
                alt="" class="img">
        </div>
        <?php else:?>
        <span class="dot"></span>
        <?php endif?>
    </div>

    <form action="<?php echo URLROOT; ?>/tweets/posttweet" method="POST" id="homeTweet"
        class="d-flex flex-column width--tweet-content" enctype="multipart/form-data">

        <input type="hidden" name="type" value="tweet">
        <input type="hidden" name="content">
        <div class="position-relative">
            <div contenteditable="true" placeholder="What's happening?" class="required tweetContent"
                id="homeTweetTweetContent" name="content" onkeydown="textAreaAdjust(this)"
                onkeyup="enableTweetSubmit('homeTweet',this)">

            </div>
            <div class="position-absolute background--white rounded z--index" id='homeTweetHashtagbox'
                style="display: none;">

            </div>
            <div class="position-absolute background--white rounded z--index" id='homeTweetMentionbox'
                style="display: none;">

            </div>
        </div>
        <div id="homeTweetUploadedImagesBox" class="w-100 d-flex flex-row flex-wrap justify-content-between">

        </div>
        <div class="d-flex flex-row justify-content-between mt-3 w-100">
            <div class="w-50 d-flex flex-row">
                <input type="hidden" name="image" id='homeTweetImage1' value=''>
                <input type="hidden" name="image" id='homeTweetImage2' value=''>
                <input type="hidden" name="image" id='homeTweetImage3' value=''>
                <input type="hidden" name="image" id='homeTweetImage4' value=''>
                <label for="homeTweetUploadImage" class="position-relative w-100">
                    <input type="file" id="homeTweetUploadImage" class="w-25" name="file"
                        style="opacity: 0; z-index:-1; position:absolute" onchange="imageUpload('homeTweet')">
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
                <button type="submit" onclick="postTweet(event, 'homeTweet')"
                    class="btn btn-primary rounded-pill background--blue border--blue" disabled>Tweet</button>
            </div>

        </div>
    </form>
</div>