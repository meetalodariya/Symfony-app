var emailElement = $('#email');
var errEmail = $('#errorEmail');

var passElement = $('#password');
var errPass = $('#errorPass');

var flag;

function submitForm(e) {
    err = '';
    var email = emailElement.val();
    var password= passElement.val();

    if(email==='' || password==='')
    {
        if(email===''){
            err = "Fill this field";
            removeError(errEmail,emailElement);
            displayError(err,errEmail,emailElement);
        }
        if(password==='')
        {
            err= "Fill this field";
            removeError(errPass,passElement);
            displayError(err,errPass,passElement)
        }
    }
    else if(wrongPassword(password)){
        error= "Invalid Credentials";
        removeError(errPass,passElement);
        displayError(error,errPass,passElement)
    }
    else
    {
      $('#loginForm').submit();
    }
}

function wrongPassword(pass){
    var email = emailElement.val();
    var password= passElement.val();
    var arr = {"email" : email , "password": password};
    $.ajax({
        async: false,
        type: 'GET',
        url: '/authenticate',
        data: arr,
        contentType: 'application/json;charset=UTF-8',
        success: (data) => {
            if (data.verified===false) {
                flag = true;
            }
            else {
                removeError(errPass,passElement);
                flag = false;
            }
        },
        error: () => {
            flag= false;
        }
    });

    return flag;

}


emailElement.focusout(()=>{
    var email = emailElement.val();
    var arr = {"email": email};
    $.ajax({
        type: 'GET',
        url: '/getemail',
        data: arr,
        contentType: 'application/json;charset=UTF-8',
        success: (data) => {
            if (data.exist===false) {
                existEmail= false;
                var error= "Email could not be found.Create a new account";
                removeError(errEmail,emailElement);
                displayError(error,errEmail,emailElement);
            }
            else {
                existEmail=true;
                removeError(errEmail,emailElement);
            }
        },
        error: () => {
            console.log('Something went wrong.Try again later.');
        },
    });
});



function displayError(err , errElement , mainElement) {
    errElement.text('');
    errElement.text(err);
    mainElement.addClass('is-invalid');
}

function removeError(errElement , mainElement) {
    errElement.text('');
    mainElement.removeClass('is-invalid');
}

