function checkNotifications(){
    setInterval(function(){
        let notification = document.getElementById("notificationIcon");
        $.ajax({
            type: 'post',
            url: 'http://localhost/masha/twitter/notifications/checknotificaitons',
            data: {
            },
            dataType: "json",
            success: function (response) {
                if(response.length > 0){
                    if (notification.hasChildNodes() && notification.children.length > 2) {
                        notification.removeChild(notification.children[notification.children.length-1]);
                      }
                    const node = document.createElement("span");
                    node.classList.add('position-absolute','translate-middle','badge','rounded-pill','background--blue');
                    node.style.top = "15%";
                    node.style.right = "0";
                    node.innerHTML = response.length;
                    notification.appendChild(node);

                }
                
            },
            beforeSend: function () {
                // Display spinner
    
            },
            complete: function () {
                // Hide spinner
    
            }});

    }, 5000)

}

// checkNotifications();