


function enableTweetSubmit(formName, element) {
    let inputs = document.querySelectorAll('#' + formName + ' .required');
    let btn = document.querySelector('#' + formName + ' button[type="submit"]');
    let hashtagbox = document.getElementById(formName + 'Hashtagbox');
    let mentionbox = document.getElementById(formName + 'Mentionbox');

    let isValid = true;

    let str = element.value;
    str = document.querySelector('#' + formName + ' [contenteditable]').textContent;

    let spaceIndex = str.lastIndexOf(" ") + 1;
    let checkHashtag = false;
    let checkMention = false;

    
    let substr = str.slice(spaceIndex, element.selectionStart) ;
    if(substr[0] === "#"){
        checkHashtag = true;
    
    } else if(substr[0] === "@"){
        checkMention = true;
    }

    // Else get position of # and space

    // if(checkHashtag){
    //     checkHashtags(substr.slice(1));
    // }
    
    if(substr.length === 0 && (hashtagbox.style.display === 'block')){
        hashtagbox.style.display = 'none';
    }
    if(substr.length === 0 && (mentionbox.style.display === 'block')){
        mentionbox.style.display = 'none';
    }



    for (var i = 0; i < inputs.length; i++) {
        let changedInput = inputs[i];
        setProgress(changedInput.textContent.trim().length, formName);

        if (changedInput.textContent.trim().length === 0) {
            isValid = false;
            break;
        }
    }

    btn.disabled = !isValid;

    

}

// function checkHash(str){

// }



document.addEventListener('click',function(e){
    if(e.target){

        if(e.target.id.includes("TweetContent")){
            checkHashtagOnClick(e.target);
            checkMentionOnClick(e.target);

        }

         if(e.target.id.includes('HashtagSuggestion')){
            hashtagAutoFinish(e.target);
             
         }
         if(e.target.id.includes('MentionSuggestion')){
            mentionAutoFinish(e.target);
             
         }
     }
 });

 document.addEventListener("input", function(e){
    if(e.target){
        if(e.target.classList.contains("tweetContent")){
            checkHashtagOnClick(e.target);
            checkMentionOnClick(e.target);
        }
    }
 })



 function getCaretPosition(editableDiv) {
    var caretPos = 0,
      sel, range;
    if (window.getSelection) {
      sel = window.getSelection();
      if (sel.rangeCount) {
        range = sel.getRangeAt(0);
        if (range.commonAncestorContainer.parentNode == editableDiv) {
          caretPos = range.endOffset;
        }
      }
    } else if (document.selection && document.selection.createRange) {
      range = document.selection.createRange();
      if (range.parentElement() == editableDiv) {
        var tempEl = document.createElement("span");
        editableDiv.insertBefore(tempEl, editableDiv.firstChild);
        var tempRange = range.duplicate();
        tempRange.moveToElementText(tempEl);
        tempRange.setEndPoint("EndToEnd", range);
        caretPos = tempRange.text.length;
      }
    }
    return caretPos;
  }

function setProgress(charnum, formName) {
    let percent = (100 * charnum) / 280;

    let progressCircle = document.querySelector("#" + formName + " .progress");
    let radius = progressCircle.r.baseVal.value;
    //circumference of a circle = 2πr;
    let circumference = radius * 2 * Math.PI;

    progressCircle.style.strokeDasharray = circumference;
    progressCircle.style.strokeDashoffset = circumference - (percent / 100) * circumference;
}

// Adjust size of the 
function textAreaAdjust(element) {
    element.style.height = "1px";

    if(element.scrollHeight > 58){
        element.style.height = (25+element.scrollHeight)+"px";

    }
}

// Jump to top 
  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }




//   Open retweet pop
  function openPrompt( event, id, origin_id){
    event.preventDefault();
    event.stopPropagation();

    let retweetPrompt = document.querySelector("#retweetPop" + origin_id);
    let undoRetweetPrompt = document.querySelector("#undoRetweetPop" + origin_id);

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/tweets/checkuserretweet',
        data: {
            tweet_id: id
        },
        dataType: "json",
        success: function (response) {
            if(response){
                if(undoRetweetPrompt.classList.contains('d-none')){
                    undoRetweetPrompt.classList.remove("d-none");
                    undoRetweetPrompt.classList.add("d-block");
                }else{
                    undoRetweetPrompt.classList.remove("d-block");
                    undoRetweetPrompt.classList.add("d-none");
            
                }
            }else{
                if(retweetPrompt.classList.contains('d-none')){
                    retweetPrompt.classList.remove("d-none");
                    retweetPrompt.classList.add("d-block");
                }else{
                    retweetPrompt.classList.remove("d-block");
                    retweetPrompt.classList.add("d-none");
            
                }
            }
        },
        beforeSend: function () {
            // Display spinner

        },
        complete: function () {
            // Hide spinner

        }});

    
    
  }

  function retweet(event, id){
    //   console.log(id)
    event.stopPropagation();
    event.preventDefault();

      let retweetIcon = document.getElementById("retweetIcon" + id);
      let retweetCount = document.getElementById("retweetCount" + id);
    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/tweets/retweet',
        data: {
            retweet: 'retweet',
            origin_tweet_id: id
        },
        dataType: "json",
        success: function (response) {
            // console.log(response);
            // console.log(response.retweet_count);
            // retweetCount.innerHTML = response.retweet_count;

            // likeCount.innerHTML = response.likes_count;
            if (response.retweet_count === 0) {
                retweetCount.innerHTML = "";
                retweetCount.classList.remove("text--green");
                retweetIcon.classList.remove("fill--green");
            } else {
                retweetCount.innerHTML = response.retweet_count;
                if(!retweetCount.classList.contains("text--green")){
                    retweetCount.classList.add("text--green");
                    retweetIcon.classList.add("fill--green");
                }
            }
            closePopup(id);

        },
        beforeSend: function () {
            // Display spinner

        },
        complete: function () {
            // Hide spinner

        }
    });
  }

  function undoRetweet(event, id, type){
        
      console.log(id)
      console.log(type)
    //   let tweet = document.getElementById('tweet' + id);
    event.stopPropagation();
    event.preventDefault();

      $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/tweets/undoretweet',
        data: {
            undo_retweet: 'undo_retweet',
            retweet_id: id,
            tweet_type: type
        },
        dataType: "json",
        success: function (response) {

            if(response.result){
                // Hide retweet if it's displayed on the page
                if(document.getElementById("tweet" + response.tweet_id)){
                    document.getElementById("tweet" + response.tweet_id).classList.add("d-none")
                }

                // Update original tweet's retweet count
                let retweetIcon = document.getElementById("retweetIcon" + response.origin_tweet_id);
                let retweetCount = document.getElementById("retweetCount" + response.origin_tweet_id);

                if (response.retweet_count === 0) {
                    retweetCount.innerHTML = "";
                    retweetCount.classList.remove("text--green");
                    retweetIcon.classList.remove("fill--green");
                } else {
                    retweetCount.innerHTML = response.retweet_count;
                    if(!retweetCount.classList.contains("text--green")){
                        retweetCount.classList.add("text--green");
                        retweetIcon.classList.add("fill--green");
                    }
                }

                // document.getElementById("undoRetweetPop" + response.origin_tweet_id).classList.remove("d-block");
                // document.getElementById("undoRetweetPop" + response.origin_tweet_id).classList.add("d-none");
                closePopup(response.origin_tweet_id);
            }

        },
        beforeSend: function () {
            // Display spinner

        },
        complete: function () {
            // Hide spinner

        }
    });
  }


  function postTweet(event, form_id){
    
    event.preventDefault();
    event.stopPropagation();

    // Prepare data
    let hashtags = document.querySelector('#' + form_id + ' [contenteditable]').textContent.split(' ').filter(v=> v.startsWith('#'));
    hashtags = hashtags.map(function(hash){return hash.slice(1)})
    hashtags = hashtags.length > 0 ? hashtags : [''];

    let content = document.querySelector('#' + form_id + ' input[name = content]').value;

    let images = document.querySelectorAll("[name=image]");
    let image_ids = [];
    for(let i = 0; i < images.length; i++){
        if(images[i].value > 0){
            image_ids.push(images[i].value);
        }else{
            image_ids.splice(i, 1);
        }
    }
    image_ids = image_ids.length > 0 ? image_ids : [''];
    
    // Send data to backend
    $.ajax({
      type: 'post',
      url: 'http://localhost/masha/twitter/tweets/posttweet',
      data: {
          post_tweet: 'post_tweet',
          hashtags: hashtags, 
          content: content,
          type: 'tweet',
          images: image_ids
      },
        dataType: "json",
        success: function (response) {
        if(response){
            document.querySelector('#' + form_id + ' [contenteditable]').innerText = "";
            document.querySelector('#' + form_id + ' input[name = content]').value = '';
            document.querySelector('#'+form_id+ 'UploadedImagesBox').innerHTML = '';
        }

      },
      beforeSend: function () {
          // Display spinner

      },
      complete: function () {
          // Hide spinner

      }
    });
  };



function like(event, id, origin_id) {
    event.stopPropagation();
    event.preventDefault();
    
    let likeCount = document.querySelector("#like" + id + " span");
    let likeIcon = document.querySelector("#like" + id + " i");
    let originLikeCount = document.querySelector("#like" + origin_id + " span");
    let originLikeIcon = document.querySelector("#like" + origin_id + " i");
    

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/tweets/like',
        data: {
            like: 'like',
            tweet_id: origin_id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            likeCount.innerHTML = response.likes_count;
            originLikeCount.innerHTML = response.likes_count;
            if (response.user_like) {
                likeCount.classList.add('text--pink');
                likeIcon.classList.add('text--pink');
                likeIcon.classList.remove('bi-heart');
                likeIcon.classList.add('bi-heart-fill');

                originLikeCount.classList.add('text--pink');
                originLikeIcon.classList.add('text--pink');
                originLikeIcon.classList.remove('bi-heart');
                originLikeIcon.classList.add('bi-heart-fill');
            } else {
                likeCount.classList.remove('text--pink');
                likeIcon.classList.remove('text--pink');
                likeIcon.classList.remove('bi-heart-fill');
                likeIcon.classList.add('bi-heart');

                originLikeCount.classList.remove('text--pink');
                originLikeIcon.classList.remove('text--pink');
                originLikeIcon.classList.remove('bi-heart-fill');
                originLikeIcon.classList.add('bi-heart');
            }

        },
        beforeSend: function () {
            // Display spinner

        },
        complete: function () {
            // Hide spinner

        }
    });
}

function imageUpload(form_id){
    // console.log(document.getElementById(form_id))
    // console.log($("form#"+form_id))
   var img1 = document.getElementById(form_id+'Image1');
   var img2 = document.getElementById(form_id+'Image2');
   var img3 = document.getElementById(form_id+'Image3');
   var img4 = document.getElementById(form_id+'Image4');
    var image = document.getElementById(form_id+'UploadImage').files[0];
    var formData = new FormData()
    formData.append('image', image)
    // Send data to backend

    if(img4.value.length === 0){
        $.ajax({
            type: 'post',
            url: 'http://localhost/masha/twitter/images/uploadtweetimage',
            data : formData,
            contentType: false, 
            processData: false,
            success: function (response) {
                res = JSON.parse(response);
              console.log(res)
              if(res.result){
                const node = document.createElement("div");
                node.classList.add('image-width--m', 'mb-2', 'rounded', 'overflow--hidden');
                let img = `<img src="${res.img}" class="w-100">`;
                node.innerHTML = img;
                document.getElementById(form_id+"UploadedImagesBox").appendChild(node);
                // console.log(form_id);
                if(img1.value.length === 0){
                    img1.value = res.img_id;
                }else if(img2.value.length === 0){
                    img2.value = res.img_id;
                }else if(img3.value.length === 0){
                    img3.value = res.img_id;
                }else {
                    img4.value = res.img_id;
                }
    
              }
      
            },
            beforeSend: function () {
                // Display spinner
      
            },
            complete: function () {
                // Hide spinner
      
            }
          });
    }
    
}

function postComment(event, tweet_id, origin_tweet_id, form_id){
    event.preventDefault();

    let comment = document.querySelector('#' + form_id + ' [contenteditable]').textContent;
    // console.log(comment);
    // console.log(tweet_id);

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/tweets/comment',
        data: {
            type: 'comment',
            tweet_id: origin_tweet_id,
            comment : comment
        },
        dataType: "json",
        success: function (response) {
          console.log(response)
          $('#commentPopup'+tweet_id).modal('hide');
  
        },
        beforeSend: function () {
            // Display spinner
  
        },
        complete: function () {
            // Hide spinner
  
        }
      });   
    }

  function closePopup(id){
    document.getElementById("retweetPop" + id).classList.remove("d-block");
    document.getElementById("retweetPop" + id).classList.add("d-none");
    document.getElementById("undoRetweetPop" + id).classList.remove("d-block");
    document.getElementById("undoRetweetPop" + id).classList.add("d-none");
  }

  function follow(user_id){

    // let comment = document.querySelector('#' + form_id + ' [contenteditable]').textContent;
    let followBtn = document.getElementById("followBtn");
    let unfollowBtn = document.getElementById("unfollowBtn");

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/users/follow',
        data: {
            user_id: user_id
        },
        dataType: "json",
        success: function (response) {
          console.log(response)
          if(response){
            followBtn.style.display = "none";
            unfollowBtn.style.display = "block";
          }
  
        },
        beforeSend: function () {
            // Display spinner
  
        },
        complete: function () {
            // Hide spinner
  
        }
      }); 
  }


  function unfollow(user_id){
      console.log("Running very important business");

    // let comment = document.querySelector('#' + form_id + ' [contenteditable]').textContent;
    let followBtn = document.getElementById("followBtn");
    let unfollowBtn = document.getElementById("unfollowBtn");

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/users/unfollow',
        data: {
            user_id: user_id
        },
        dataType: "json",
        success: function (response) {
          console.log(response)
          if(response){
            followBtn.style.display = "block";
            unfollowBtn.style.display = "none";
          }
  
        },
        beforeSend: function () {
            // Display spinner
  
        },
        complete: function () {
            // Hide spinner
  
        }
      }); 
  }


  function tweetDetails(tweet_id){
    window.location.href ='http://localhost/masha/twitter/tweets/tweet/'+ tweet_id;
  }
 

  function profileImageUpload(form_id, type){
    // console.log(document.getElementById(form_id))
    // console.log($("form#"+form_id))
    var image = document.getElementById(form_id+'UploadImage').files[0];
    var formData = new FormData();
    formData.append('image', image);
    formData.append('type', type);
        $.ajax({
            type: 'post',
            url: 'http://localhost/masha/twitter/images/uploadprofileimage',
            data : formData,
            contentType: false, 
            processData: false,
            success: function (response) {
                res = JSON.parse(response);
            //   console.log(res)
              if(res.result){
                    const node = document.createElement("div");

                  if(type === 'avatar'){
                    node.style.width = '80px';
                    node.style.height = '80px';
                    node.style.backgroundColor = '#fff';
                    node.style.borderRadius = "100%";
    
                    var img = `<img src="${res.img}" class="w-100" style="object-fit: cover;width: 100%; height: 100%; border-radius: 100%; border: 5px solid #fff">`;
                  }else{
                    node.style.width = '100%';
                    node.style.height = '200px';
                    var img = `<img src="${res.img}" style="object-fit: cover;width: 100%; height: 100%;">`;
                  }

                // node.classList.add('image-width--m', 'mb-2', 'rounded', 'overflow--hidden');
                
                node.innerHTML = img;    
                document.getElementById(form_id+"UploadedImagesBox").appendChild(node);
                console.log(form_id);
                document.getElementById(form_id+"Edit").value = res.img_id;
                document.getElementById(form_id+"Empty").style.display = "none";
    
              }
      
            },
            beforeSend: function () {
                // Display spinner
      
            },
            complete: function () {
                // Hide spinner
      
            }
          });
    
}

function saveProfileEdit(event, form_id){
    // event.preventDefault();
    let picture_id = document.getElementById("profileAvatarEdit").value;
    let background_id = document.getElementById("profileBackgroundEdit").value;
    let nickname = document.getElementById("editProfileName").value;
    let description = document.getElementById("editProfileDescription").value;

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/users/updateuserprofile',
        data: {
            picture_id: picture_id,
            background_id: background_id,
            nickname: nickname,
            description: description
        },
        dataType: "json",
        success: function (response) {
          console.log(response)
          $('#editProfile').modal('hide');
  
        },
        beforeSend: function () {
            // Display spinner
  
        },
        complete: function () {
            // Hide spinner
  
        }
      });
}