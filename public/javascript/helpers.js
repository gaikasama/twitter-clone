function displayErrors(form_id, errors){
    // console.log(errors.usernameError)
    for (var key in errors) {
        // Display error text
        document.getElementById(key).innerHTML = errors[key];

        // Add red border to input
        let inputSelector = `${form_id} input[name="${key.split("Error")[0]}"]`;
        document.querySelector(inputSelector).classList.add("border--red");
    }
}

function clearErrors(form_id){
    // prepare selectors
    let errorSelector = `${form_id} .form--error`
    let inputErrorSelector = `${form_id} .border--red`

    // select all nodes with errors
    let errors = document.querySelectorAll(errorSelector);
    let inputErrors = document.querySelectorAll(inputErrorSelector);
    // console.log(errors);

    // remove error styles and messages
    errors.forEach.call(errors, function(child) {child.innerHTML = ''});
    inputErrors.forEach.call(inputErrors, function(child) {child.classList.remove("border--red");});
}


// prevent default
function preventDefault(event){
    event.preventDefault();
    event.stopPropagation();
  }


//   -----------------------------  //
//   MENTIONS                       //
//   -----------------------------  //
function mentionAutoFinish(e){
    var id = '';
    if(e.id === 'modalTweetMentionSuggestion'){
       id = 'modalTweet';
    }else{
       id = 'homeTweet';
    }

   let mention = document.querySelector('#' + id + ' [contenteditable]').textContent.split(' ').filter(v=> v.startsWith('@'))
   for(let i = 0; i < mention.length; i++){
       if(e.innerHTML.includes(mention[i].slice(1))){
           let str = document.querySelector('#' + id + ' [contenteditable]').textContent;
           document.querySelector('#' + id + ' [contenteditable]').textContent = str.replace(mention[i], "@" + e.innerHTML);
       }  
   }
       document.querySelector('#' + id + ' input[name=content]').value = document.querySelector('#' + id + ' [contenteditable]').textContent;
       if(document.getElementById(id +'Mentionbox').style.display === 'block'){
           document.getElementById(id + 'Mentionbox').style.display = 'none'
       }
}

function checkMentionOnClick(e){
    var id = "";
    // console.log(e.id);

    if(e.classList.contains("modalTweet")){
        id = 'modalTweet';
    }else{
        id = 'homeTweet';
    }
    document.querySelector("#" + id + ' input[name=content]').value = document.querySelector('#' + id + ' [contenteditable]').textContent;

    let content = document.querySelector('#' + id + ' [contenteditable]').textContent;
    let mentions = getMentionFromString(content, id);
    // console.log(mentions);
    if(mentions){
        checkMentions(mentions, id);
    }
 }

 function getMentionFromString(str, formName){
    
    let caretPosition = getCaretPosition(document.querySelector('#' + formName + ' [contenteditable]'));
    // console.log(caretPosition)

    let wordStart = str.slice(0,caretPosition).lastIndexOf(" ");

    if(str[wordStart + 1] === "@"){
        let substr = str.slice(wordStart + 1,str.length);
        let wordEnd = substr.indexOf(" ");
        let hashtag = substr.slice(1, (wordEnd  === -1 ? substr.length : wordEnd))
            return hashtag;
        }else {
            return false;
        }
}
function checkMentions(str, id){
    let mentionbox = document.getElementById(id + 'Mentionbox');
    console.log(id)
    if(str.length > 0){

        mentionbox.innerHTML = "";

        $.ajax({
            type: 'post',
            url: 'http://localhost/masha/twitter/users/getuserlist',
            data: {
                mention: str
            },
            dataType: "json",
            success: function (response) {
                // console.log(response)
                if(response.length > 0){
                    for(let i = 0; i < response.length; i++){
                        const node = document.createElement("div");
                        node.classList.add('hover--gray', 'px-5', 'py-3', 'rounded');
                        node.id = id + 'MentionSuggestion';
                        mentionbox.style.display = 'block';
                        let textnode = document.createTextNode(response[i]);
                        node.appendChild(textnode);
                        mentionbox.appendChild(node);
                    }
                }else{
                    if(mentionbox.style.display === 'block'){
                        mentionbox.style.display = 'none'
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
}

//   -----------------------------  //
//   HASHTAGS                       //
//   -----------------------------  //
function hashtagAutoFinish(e){
    var id = '';
    if(e.id === 'modalTweetHashtagSuggestion'){
       id = 'modalTweet';
    }else{
       id = 'homeTweet';
    }

   let hashtags = document.querySelector('#' + id + ' [contenteditable]').textContent.split(' ').filter(v=> v.startsWith('#'))
   for(let i = 0; i < hashtags.length; i++){
       if(e.innerHTML.includes(hashtags[i].slice(1))){
           let str = document.querySelector('#' + id + ' [contenteditable]').textContent;
           document.querySelector('#' + id + ' [contenteditable]').textContent = str.replace(hashtags[i], "#" + e.innerHTML);

       }  
   }
       document.querySelector('#' + id + ' input[name=content]').value = document.querySelector('#' + id + ' [contenteditable]').textContent;
       if(document.getElementById(id +'Hashtagbox').style.display === 'block'){
           document.getElementById(id + 'Hashtagbox').style.display = 'none'
       }
}

function checkHashtagOnClick(e){
    var id = "";
    // console.log(e.id);

    if(e.classList.contains("modalTweet")){
        id = 'modalTweet';
    }else{
        id = 'homeTweet';
    }
    document.querySelector("#" + id + ' input[name=content]').value = document.querySelector('#' + id + ' [contenteditable]').textContent;

    let content = document.querySelector('#' + id + ' [contenteditable]').textContent;
    let hashtag = getHashtagFromString(content, id);
    // console.log(hashtag);
    if(hashtag){
        checkHashtags(hashtag, id);
    }
 }

 function getHashtagFromString(str, formName){
    
    let caretPosition = getCaretPosition(document.querySelector('#' + formName + ' [contenteditable]'));
    // console.log(caretPosition)

    let wordStart = str.slice(0,caretPosition).lastIndexOf(" ");

    if(str[wordStart + 1] === "#"){
        let substr = str.slice(wordStart + 1,str.length);
        let wordEnd = substr.indexOf(" ");
        let hashtag = substr.slice(1, (wordEnd  === -1 ? substr.length : wordEnd))
        // console.log(wordEnd)
        // console.log(wordEnd  === -1)
        // console.log(`substr.slice(1, ${(wordEnd  === -1 ? substr.length : wordEnd)})`)
            return hashtag;
        }else {
            return false;
        }
}

function checkHashtags(str, id){
    // console.log(str)
    // let hashtags = str.split(' ').filter(v=> v.startsWith('#'))
    let hashtagbox = document.getElementById(id + 'Hashtagbox');
    
    if(str.length > 0){

        hashtagbox.innerHTML = "";

        $.ajax({
            type: 'post',
            url: 'http://localhost/masha/twitter/hashtags/gethashtags',
            data: {
                hashtag: str
            },
            dataType: "json",
            success: function (response) {
                // console.log(response)
                if(response.length > 0){
                    for(let i = 0; i < response.length; i++){
                        const node = document.createElement("div");
                        node.classList.add('hover--gray', 'px-5', 'py-3', 'rounded');
                        node.id = id + 'HashtagSuggestion';
                        hashtagbox.style.display = 'block';
                        let textnode = document.createTextNode(response[i]);
                        node.appendChild(textnode);
                        hashtagbox.appendChild(node);
                    }
                }else{
                    if(hashtagbox.style.display === 'block'){
                        hashtagbox.style.display = 'none'
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

}


function searchHashtag(event){
    event.stopPropagation();
    event.preventDefault();
    let hashtag = event.target.innerText.slice(1);
    //  console.log(hashtag)
    window.location = 'http://localhost/masha/twitter/tweets/hashtagsearch/' + hashtag;
 }
