<div class="modal fade" id="commentRetweetPopup<?php echo $tweet['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comment Retweet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="<?php echo URLROOT; ?>/tweets/commentretweet" method="POST">
                <input type="hidden" name="type" value="comment_retweet">
                <input type="hidden" name="originTweetId" value="<?php echo $tweet['id'];?>">
                <div>
                    <?php echo $tweet['id'];?>
                </div>
                <div>
                    <input class="form-control form-control-lg border--none" name="content" type="text" placeholder="Add a comment" aria-label=".form-control-lg example">
                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary rounded-pill">Retweet</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
