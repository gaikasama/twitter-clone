// TODO name validation, email validation, birthday validation
// Email validation: pattern and if it already exists

// Email pattern 
function validateEmail(email){
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}