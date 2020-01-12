var errElement = $("#loginError");
var errDiv = $("#errorDiv");


function submitForm(e) {


    var err = '';
    var email = $('#loginEmail').val();
    var password = $('#loginPassword').val();


    if(email == '' || password == ''){
        err = 'Fill all the fields';
        displayError(err);
    }
    else if (!validateEmail(email))
    {
        err = 'Email is not in correct format';
        displayError(err);

        return false;
    }
    else
    {
        var frm = $('#loginForm');

         $.ajax({
             type: frm.attr('method'),
             url: '/login',
             data: JSON.stringify(frm.serializeArray()),
             contentType: 'application/json;charset=UTF-8',
             success: function (data) {
                 jsonData = JSON.parse(data);
                 if (jsonData.success === true) {

                 }
                 else {
                     displayError( jsonData.error);
                 }
             },
             error: function (data) {
                 console.log('An error occurred.');
                 console.log(data);
             },
         });
    }

}

function displayError(err) {
    errDiv.text(err);
    errElement.removeAttr('hidden');

}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}