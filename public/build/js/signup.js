var nameElement = $('#name');
var errDivName = $('#errorName');

var emailElement = $('#email');
var errDivEmail = $('#errorEmail');

var usernameElement = $('#username');
var errDivUserName = $('#errorUserName');

var passText =$('#password');
var errDivPass = $('#errorPass');

var confirmPassText =$('#confirmPass');
var errDivConPass = $('#errorCon');
var frm = $('#signupForm');

var existEmail = false
var existUser = false

function signup(e) {
    var err = '';
    var pwd = passText.val();
    var conPwd = confirmPassText.val();
    var fullName = nameElement.val();
    var userName = usernameElement.val();
    var email = emailElement.val();


    removeError(errDivPass , passText );
    removeError(errDivConPass , confirmPassText  );
    removeError(errDivName , nameElement );
    removeError(errDivUserName , usernameElement );
    removeError(errDivEmail , emailElement );

    if(pwd === '' || conPwd=== '' ||fullName=== '' ||userName=== '' ||email=== '' )
    {
        err = 'Please fill this field';
        if(pwd==='')
        {
            displayError(err ,errDivPass , passText );
        }
        if(conPwd===''){

            displayError(err ,errDivConPass , confirmPassText );

        }
        if(fullName===''){
            displayError(err ,errDivName , nameElement );
        }
        if(userName===''){

            displayError(err ,errDivUserName , usernameElement );

        }
        if(email===''){
            displayError(err ,errDivEmail , emailElement );
        }
        return false;

    }
    else if(!isvalid(email)){
        error = "Enter a valid Email"
        removeError(errDivEmail, emailElement)
        displayError(error , errDivEmail , emailElement)
    }

    else if (pwd.length < 6 || pwd.length > 32 )
    {
        err = 'Password length must be between 6 and 32';
        displayError(err ,errDivPass , passText );
        return false;
    }
    else if(pwd !== conPwd){
        err = 'Passwords are not matching';
        displayError(err , errDivConPass , confirmPassText );
        return false;
    }
    else if(existUser){
        var errorUser = "Username already taken"
        removeError(errDivUserName , usernameElement);
        displayError(errorUser , errDivUserName , usernameElement)
        return false;
    }
    else if(existEmail){
        var errorEmail = "Email already taken.Try another one"
        removeError(errDivEmail, emailElement)
        displayError(errorEmail , errDivEmail , emailElement)
        return false;
    }
    else
    {
        $("#signupForm").submit();


    }
}

emailElement.onblur(()=>{
    var email = emailElement.val();
    var arr = {"email": email}
    $.ajax({
        type: 'GET',
        url: '/getemail',
        data: arr,
        contentType: 'application/json;charset=UTF-8',
        success: (data) => {
            if (data.exist===true) {
                existEmail= true
                var error= "Email already taken.Try another one"
                removeError(errDivEmail, emailElement)
                displayError(error , errDivEmail , emailElement)
            }
            else {
                existEmail=false
                removeError(errDivEmail, emailElement);
            }
        },
        error: () => {
            console.log('Something went wrong.Try again later.');
        },
    });
    })

usernameElement.onblur(()=>{
    var userName = usernameElement.val();
    var arr = {"username": userName}
    $.ajax({
        type: 'GET',
        url: '/getuser',
        data: arr,
        contentType: 'application/json;charset=UTF-8',
        success: (data) => {
            if (data.exist===true) {
                existUser = true
                var error = "Username already taken"
                removeError(errDivUserName , usernameElement);
                displayError(error , errDivUserName , usernameElement)
            }
            else {
                existUser = false
                removeError(errDivUserName , usernameElement);
            }
        },
        error: () => {
            console.log('Something went wrong.Try again later.');
        },
    });
})

function displayError(err , errorDiv , field) {
    errorDiv.text('');
    errorDiv.text(err);
    field.addClass('is-invalid');
}

function removeError(errorDiv , field) {
    errorDiv.text('');
    field.removeClass('is-invalid');

}

function isvalid(email) {
    var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(String(email).toLowerCase());
}
