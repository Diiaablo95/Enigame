//var messageText = document.createTextNode(errorMessage);

var errorP = document.getElementById("errorP");
errorP.innerHTML = "<span style = 'color : red;'>Credenziali inserite errate. Riprovare</span>";
errorP.style.visibility = "visible";

var secondarySection = document.getElementById("secondarySection");
var loginDiv = document.getElementById("loginDiv");
secondarySection.insertBefore(errorP, loginDiv);
