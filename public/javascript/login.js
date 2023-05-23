function toggleVisibility(event, int) {
    event.preventDefault()
    // console.log(this);
    document.getElementById(`step${int - 1}`).style.display = 'none';
    document.getElementById(`step${int}`).style.display = 'block';

    let username = document.getElementById("usernameRegister").value;
    let email = document.getElementById("requiredEmail").value;
    document.querySelector("#step2 input[name='username']").value = username;
    document.querySelector("#step2 input[name='email']").value = email;
    // console.log(document.querySelector("#step2 input[name='username']").value);
    // console.log(document.querySelector("#step2 input[name='email']").value);

    
}

function changeRegInput(str) {
    // console.log(str);

    if (str == "email") {
        document.getElementById("emailRegister").style.display = 'block';
        document.getElementById("phoneRegister").style.display = 'none';
    } else if (str == "phone") {
        document.getElementById("phoneRegister").style.display = 'block';
        document.getElementById("emailRegister").style.display = 'none';
    }
}

function enableSubmit(event) {
    // console.log(event.target.id);
    // console.log(event.target);
    // console.log(event.target.value);
    // registerFormValue(event.target.id,event.target.value);
    let inputs = document.getElementsByClassName('required'); 
    let inputEmail = document.getElementById('requiredEmail'); 
    let inputPhone = document.getElementById('requiredPhone'); 
    let btn = document.querySelector('button[name="step1"]');
    let isValid = true;


    if(inputEmail.value.length === 0 && inputPhone.value.length === 0){
        isValid = false;
    }

    for (var i = 0; i < inputs.length; i++) {

        let changedInput = inputs[i];
        if (changedInput.value.length === 0) {
                isValid = false;
                break;
            
        }
     }

     if(inputEmail.value.length > 0){
        let emailValidation = validateEmail(inputEmail.value);
        isValid = emailValidation;
        console.log(emailValidation)
    }

    btn.disabled = !isValid;
}

function register(event, step){
    // event.preventDefault();
    clearErrors(`#step${step}`);


    const username = document.querySelector(`#step${step} input[name='username']`).value;
    const email =  document.querySelector(`#step${step} input[name='email']`).value;
    const nickname = document.querySelector("#step2 input[name='nickname']").value;
    const password = document.querySelector("#step2 input[name='password']").value;
    const confirm_password = document.querySelector("#step2 input[name='confirmPassword']").value;

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/users/signup',
        data: {
            username: username,
            nickname: nickname,
            email: email,
            password: password,
            confirm_password: confirm_password,
            step: step
        },
        dataType: "json",
        success: function (response) {
            if(step === 1 && response.result){
                document.getElementById(`step${step}`).style.display = 'none';
                document.getElementById(`step${step + 1}`).style.display = 'block';
                document.querySelector("#step2 input[name='username']").value = response.username;
                document.querySelector("#step2 input[name='email']").value = response.email;
            }else if(step === 2 && response.result){
                window.location.href = 'http://localhost/masha/twitter/tweets/home';
            }
            
            // Error handling
            displayErrors(`#step${step}`, response.errors);
           
        },
        beforeSend: function () {
            // Display spinner

        },
        complete: function () {
            // Hide spinner

        }});
}

