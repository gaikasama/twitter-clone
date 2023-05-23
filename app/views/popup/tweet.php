<!-- Modal -->
<div class="modal fade" id="tweetPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog position-relative">
    <div class="modal-content">


      <div class="modal-header border--none">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="px-3 pb-2  d-flex justify-content-between">
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
        <div class="modal-body position-relative pb-0">
          <div class="">
            <form method="POST" id="modalTweet">
              <input type="hidden" name="type" value="tweet">
              <input type="hidden" name="content">
              <!-- <div>
                    <textarea class="required" name="content" maxlength="280" id="tweetContent" onkeydown="textAreaAdjust(this)" onkeyup="enableTweetSubmit('modalTweet',this)" style="overflow:hidden" placeholder="What's happening"></textarea>
                </div> -->
              <div contenteditable="true" class="required tweetContent modalTweet" id="modalTweetTweetContent"
                name="content" onkeydown="textAreaAdjust(this)" onkeyup="enableTweetSubmit('modalTweet',this)">

              </div>
              <div id="modalTweetUploadedImagesBox" class="w-100 d-flex flex-row flex-wrap justify-content-between">

              </div>
              <div class="d-flex flex-row justify-content-between mt-3 w-100">
                <div class="w-50 d-flex flex-row">
                  <input type="hidden" name="image" id='modalTweetImage1' value=''>
                  <input type="hidden" name="image" id='modalTweetImage2' value=''>
                  <input type="hidden" name="image" id='modalTweetImage3' value=''>
                  <input type="hidden" name="image" id='modalTweetImage4' value=''>
                  <label for="modalTweetUploadImage" class="position-relative w-100">
                    <input type="file" id="modalTweetUploadImage" class="w-25" name="file"
                      style="opacity: 0; z-index:-1; position:absolute" onchange="imageUpload('modalTweet')">
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
                  <!-- <svg viewBox="0 0 24 24" aria-hidden="true" width="20" height="20" class="fill--blue">
                        <g>
                            <path
                                d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z">
                            </path>
                            <circle cx="8.868" cy="8.309" r="1.542"></circle>
                        </g>
                    </svg> -->
                </div>
                <div class="d-flex flex-row align-items-center">
                  <div class="circle-wrap me-2">
                    <svg width="30" height="30">
                      <circle r="10" cx="15" cy="15" class="track"></circle>
                      <circle r="10" cx="15" cy="15" class="progress"></circle>
                    </svg>
                  </div>
                  <button type="submit" onclick="postTweet(event, 'modalTweet')"
                    class="btn btn-primary rounded-pill background--blue border--blue" disabled>Tweet</button>

                </div>

              </div>
            </form>
          </div>
          <div class="position-absolute background--white rounded bottom--negative" id='modalTweetHashtagbox'
            style="display: none;">

          </div>
        </div>
      </div>


      <!-- <div class="modal-footer border--none">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>

  </div>
</div>