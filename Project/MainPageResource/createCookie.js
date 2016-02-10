var TOTAL_DAYS = 7;

window.addEventListener("load", function() {
    document.getElementById("loginButton").addEventListener("click", checkRememberMe, false);
}, false);

//Prendo il tempo attuale, lo aumento di sette giorni e lo imposto come tempo di scadenza del cookie.
function checkRememberMe() {

    var rememberCheckbox = document.getElementsByName("remember")[0];
    var cookieKey = "loginSession";
    var userID = document.getElementsByName("userName")[0].value;
    if (rememberCheckbox.checked) {
        createCookie(cookieKey, userID, TOTAL_DAYS);
    } else {
        createCookie(cookieKey, userID, 0);
    }
}

function createCookie(name, value, expireDays) {
    if (expireDays) {
        var date = new Date();
        date.setTime(date.getTime() + (expireDays * 24 * 60 * 60 * 1000));
        var expires = ";expires = " + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + " = " + value + expires;
}