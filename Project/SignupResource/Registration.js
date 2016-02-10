var emailError = false;
var usernameError = false;

var timer = 1500;

var PARENT_DIV = "div";

var EMAIL_ID = "#email";
var USERNAME_ID = "#username";
var SURNAME_ID = "#surname";
var NAME_ID = "#name";
var PASSWORD_ID ="#password";
var CAPTCHA_ID ="#captcha_code";
var DATE_ID = "#date";
var GET_SEX_RADIO_PARAM = "input[type='radio'][name='sex']:checked";

var BTN_SUBMIT_ID ="#btnSubmit";

//var SUCCESS_CLASS = "has-success";
//var ERROR_CLASS = "has-error";

var EMAIL_ALERT = "#emailAlert";
var USERNAME_ALERT = "#usernameAlert";
var CAPTCHA_ALERT = "#captchaAlert";
var FORM_ERRORS_ALERT = "#formErrorsAlert";
var REGISTRATION_SUCCESS_ALERT = "#registrationSuccess";

var EMAIL_VALIDATION_PAGE = "/SignupResource/php/EmailAlreadyExistCheck.php";
var USERNAME_VALIDATION_PAGE = "/SignupResource/php/UsernameAlreadyExistCheck.php";
var CAPTCHA_CHECK_PAGE = "/SignupResource/php/CaptchaCheck.php";

var REGISTRATION_PAGE = "/SignupResource/php/Register.php";


window.addEventListener("load", removeAllWarnings, false);

function removeAllWarnings() {
  $(REGISTRATION_SUCCESS_ALERT).hide();
  $(EMAIL_ALERT).hide();
  $(USERNAME_ALERT).hide();
  $(CAPTCHA_ALERT).hide();
  $(FORM_ERRORS_ALERT).hide();
}

//-------------------------EMAIL VALIDATION ---------------------------
function showEmailAlert(){
    $(EMAIL_ALERT).show();
    setTimeout(function() {hideEmailAlert();}, timer);
}

function hideEmailAlert() {
    $(EMAIL_ALERT).hide();
}

function emailValidation() {
    hideEmailAlert();
    emailError = false;
    
    $emailElement = $(EMAIL_ID);
    var emailValue = $.trim($emailElement.val());
    
    if (emailValue !== "") {
        $regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

        if ($regex.test(emailValue) === false) {
            showEmailAlert();
            emailError = true;
        } else {
            $.ajax({
                url: EMAIL_VALIDATION_PAGE,
                dataType: "json",
                data: { email: emailValue},
                method: "post"
            }).done(function(json) { 
                OnEmailCheck(json);
            });
        }    
    } 
}

function OnEmailCheck(json) {
    if (json["status"]) {
        if (json["validEmail"] === false) {
            showEmailAlert();
            emailError = true;
        }
    } else {
        console.log("server connection error");
    }
}

//-------------------- END - EMAIL VALIDATION ----------------------------------

function showUsernameAlert() {
    $(USERNAME_ALERT).show();
    setTimeout(function() {hideUsernameAlert();}, timer);
}

function hideUsernameAlert() {
    $(USERNAME_ALERT).hide();
}

function usernameCheck() {
    hideUsernameAlert();
    usernameError = false;
    
    var usernameVal = $.trim( $(USERNAME_ID).val() );
    if (usernameVal !== "") {
       $.ajax({
            url: USERNAME_VALIDATION_PAGE,
            dataType: "json",
            data: { username: usernameVal},
            method: "post"
        }).done(function(json) { 
            OnUsernameValidationResponse(json);
        }); 
    }
}

function OnUsernameValidationResponse(json)  {
    if (json["status"]) {
        if (json["validUsername"] === false) {
            showUsernameAlert();
            usernameError = true;
        }
    } else {
        console.log("server connection error");
    }
}
//--------------------------END EMAIL VALIDATION--------------------------------


//-------------------------FORM VALIDATION--------------------------------------
function showCaptchaErrorsAlert() {
    $(CAPTCHA_ALERT).show();
    setTimeout(function() {hideCaptchaErrorsAlert();}, timer);
}

function hideCaptchaErrorsAlert(){
    $(CAPTCHA_ALERT).hide();
}
function showFormErrorsAlert() {
    $(FORM_ERRORS_ALERT).show();
    setTimeout(function() {hideFormErrorsAlert();}, timer);
}

function hideFormErrorsAlert() {
    $(FORM_ERRORS_ALERT).hide();
}

function btnSubmitLoading() {
    $(BTN_SUBMIT_ID).button('loading');
}

function btnSubmitNormal() {
    $(BTN_SUBMIT_ID).button('reset');
}

function formValidation() {
    var username = $.trim( $(USERNAME_ID).val());
    var email = $.trim( $(EMAIL_ID).val());
    var name = $.trim( $(NAME_ID).val());
    var surname = $.trim( $(SURNAME_ID).val());
    var password = $.trim( $(PASSWORD_ID).val());
    var date = $.trim( $(DATE_ID).val());
    var captcha = $.trim( $(CAPTCHA_ID).val());
    var sex = $(GET_SEX_RADIO_PARAM).val();
    
    hideRegistrationSuccessAlert();
    hideFormErrorsAlert();
    
    btnSubmitLoading();
    
    if (name !== "" &&
        surname !== "" &&
        password !== "" &&
        date !== "" &&
        captcha !== "" &&
        username !== "" &&
        email !== "" &&
        emailError === false &&
        usernameError === false) {
                
            hideCaptchaErrorsAlert();
             $.ajax({
                url: CAPTCHA_CHECK_PAGE,
                dataType: "json",
                data: { captcha_code: captcha},
                method: "post"
            }).done(function(json) { 
                if (json["status"] === true) {
                    if (json["validCaptcha"] === true) {
                        GoOnWithRegistration(username, email, name, surname, password, date,sex); 
                    } else {
                        showCaptchaErrorsAlert();
                        btnSubmitNormal();
                    }
                }
            }); 
    } else {
        showFormErrorsAlert();
        btnSubmitNormal();
    }
}

function showRegistrationSuccessAlert() {
    $(REGISTRATION_SUCCESS_ALERT).show();
}

function hideRegistrationSuccessAlert() {
    $(REGISTRATION_SUCCESS_ALERT).hide();
}



function GoOnWithRegistration(username, email, name, surname, password, date, sex) {
    $.ajax({
            url: REGISTRATION_PAGE,
            dataType: "json",
            data: { username: username,
                    email: email,
                    name: name,
                    surname: surname,
                    password: password,
                    date: date,
                    sex: sex },
            method: "post"
        }).done(function(json) { 
            if (json["status"] === true) {
                showRegistrationSuccessAlert();
                clearForm();
            } else {
                console.log("registrazione fallita");
            }
            btnSubmitNormal();
        }); 
        
    function clearForm() {
        $(USERNAME_ID).val("");
        $(EMAIL_ID).val("");
        $(NAME_ID).val("");
        $(SURNAME_ID).val("");
        $(PASSWORD_ID).val("");
        $(DATE_ID).val("");
        $(CAPTCHA_ID).val("");
    }
}
//------------------------------------------------------------------------------