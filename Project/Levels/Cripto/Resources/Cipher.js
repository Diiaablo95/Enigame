var text;
var cipherButton;

window.addEventListener("load", initialize, false);

function initialize() {
    text = document.getElementById("plainText");
    cipherButton = document.getElementById("cipherButton");

    cipherButton.addEventListener("click", cipher, false);
}

function cipher() {
    if (document.getElementById("newPara")) {
        var paraNode = document.getElementById("newPara");
        document.getElementById("gameSection").removeChild(paraNode);
    }
    var textToCipher = text.value;
    var resultText = "";
    for (var i = 0; i < textToCipher.length; i++) {
        var characterCode = parseInt(textToCipher.charCodeAt(i));
        var cipheredCharacter = String.fromCharCode(characterCode + i);
        resultText += cipheredCharacter;
    }
	
	var resultParagraph = document.createElement("p");
 	resultParagraph.id = "newPara";
   	resultParagraph.innerHTML = "Il testo inserito, dopo l'applicazione della funzione crittografica, è : <span style = 'color : yellow'>" + resultText + "</span>";
    document.getElementById("gameSection").insertBefore(resultParagraph, document.getElementById("questionP"));
        
    plainText.value = "";
}