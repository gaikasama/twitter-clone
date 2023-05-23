// ------------------------ //
// Node list                //
// ------------------------ //

// Set node list
function getNodes(rowId){
    
    let firstNameInput = document.getElementById("first_name_input" + rowId);
    let lastNameInput = document.getElementById("last_name_input" + rowId);
    let emailInput = document.getElementById("email_input" + rowId);
    let firstNameCell = document.getElementById("first_name_cell" + rowId);
    let lastNameCell = document.getElementById("last_name_cell" + rowId);
    let emailCell = document.getElementById("email_cell" + rowId);
    let firstNameSpan = document.getElementById("first_name_span" + rowId);
    let lastNameSpan = document.getElementById("last_name_span" + rowId);
    let emailSpan = document.getElementById("email_span" + rowId);
    let firstNameError = document.getElementById("first_name_error" + rowId);
    let lastNameError = document.getElementById("last_name_error" + rowId);
    let emailError = document.getElementById("email_error" + rowId);
    let editButton = document.getElementById("edit_button" + rowId);
    let deleteButton = document.getElementById("delete_button" + rowId);
    let saveButton = document.getElementById("save_button" + rowId);
    let cancelButton = document.getElementById("cancel_button" + rowId);
    

    let nodeList = {
        firstNameInput : firstNameInput,
        lastNameInput: lastNameInput,
        emailInput: emailInput,
        firstNameCell : firstNameCell,
        lastNameCell: lastNameCell,
        emailCell: emailCell,
        firstNameSpan : firstNameSpan,
        lastNameSpan: lastNameSpan,
        emailSpan: emailSpan,
        firstNameError: firstNameError,
        lastNameError: lastNameError,
        emailError: emailError,
        editButton: editButton,
        deleteButton:deleteButton,
        saveButton: saveButton,
        cancelButton: cancelButton,
    }
    return nodeList;
}

// ------------------------ //
// Table input              //
// ------------------------ //

// Display input and edit row 
function editRow(rowId) {
    // Get node list
    let nodeList = getNodes(rowId);

   nodeList.firstNameCell.innerHTML = "<input type='text' placeholder='First Name' id='first_name_input" + rowId + "' value='" + nodeList.firstNameSpan.innerHTML + "' class='table__input'>";
   nodeList.lastNameCell.innerHTML = "<input type='text' placeholder='Last Name' id='last_name_input" + rowId + "' value='" + nodeList.lastNameSpan.innerHTML + "' class='table__input'>";
   nodeList.emailCell.innerHTML = "<input type='email' placeholder='Email' id='email_input" + rowId + "' value='" + nodeList.emailSpan.innerHTML + "' class='table__input'>";

    nodeList.editButton.style.display = "none";
    nodeList.deleteButton.style.display = "none";
    nodeList.saveButton.style.display = "inline-block";
    nodeList.cancelButton.style.display = "inline-block";
}

// Cancel edit
function cancelEditRow(rowId) {
    // Get node list
    let nodeList = getNodes(rowId);

    // Check if input empty set input value as value property
    if (nodeList.firstNameInput.value !== null) {
        nodeList.firstNameInput.value = nodeList.firstNameInput.getAttribute('value');
    }
    if (nodeList.lastNameInput.value !== null) {
        nodeList.lastNameInput.value = nodeList.lastNameInput.getAttribute('value');
    }
    if (nodeList.emailInput.value !== null) {
        nodeList.emailInput.value = nodeList.emailInput.getAttribute('value');
    }

    nodeList.firstNameCell.innerHTML = "<span id='first_name_span" + rowId + "'>" + nodeList.firstNameInput.value + "</span>";
    nodeList.lastNameCell.innerHTML = "<span id='last_name_span" + rowId + "'>" + nodeList.lastNameInput.value + "</span>";
    nodeList.emailCell.innerHTML = "<span id='email_span" + rowId + "'>" + nodeList.emailInput.value + "</span>";
    
    nodeList.editButton.style.display = "inline-block";
    nodeList.deleteButton.style.display = "inline-block";
    nodeList.saveButton.style.display = "none";
    nodeList.cancelButton.style.display = "none";
}

// ------------------------ //
// Popup                    //
// ------------------------ //

//Display popup
function displayPopup(rowId, userId) {
    document.getElementById("popup").classList.add('popup--show');
    document.getElementsByName('row_id').value = rowId;
    document.getElementsByName('user_id').value = userId;
 }
 
//Close popup
 function closePopup() {
     document.getElementById("popup").classList.remove('popup--show');
 }


// ------------------------ //
// Submit data              //
// ------------------------ //

// Save edited user info
function saveEdit(rowId, userId) {
    // Get node list
    let nodeList = getNodes(rowId);
    
    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/users/editUser',
        data: {
            edit_row: 'edit_row',
            id: userId,
            firstName: nodeList.firstNameInput.value,
            lastName: nodeList.lastNameInput.value,
            email: nodeList.emailInput.value
        },
        dataType: "HTML",
        success: function (response) {
            console.log(response);
            // $("#home").html() = response;
            document.getElementById("home").innerHTML = response;
        },
        beforeSend: function(){
            // Display spinner
            document.getElementById("spinner").classList.add('spinner--show');

        },
        complete: function(){
            // Hide spinner
            document.getElementById("spinner").classList.remove('spinner--show');

        }
    });
}

// Delete user
function deleteUser() {
    
    let rowId = document.getElementsByName('row_id').value;
    let userId = document.getElementsByName('user_id').value;

    $.ajax({
        type: 'post',
        url: 'http://localhost/masha/twitter/users/deleteUser',
        data: {
            delete_row: 'delete_row',
            id: userId,
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['result']) {
                closePopup();
                document.getElementById('table_row' + rowId).style.display = "none"
            }
        },
        beforeSend: function(){
            // Display spinner
            document.getElementById("spinner").classList.add('spinner--show');

        },
        complete: function(){
            // Hide spinner
            document.getElementById("spinner").classList.remove('spinner--show');

        }
    });
}

