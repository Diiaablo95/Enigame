window.addEventListener("load", startBlinking, false);

function startBlinking() {
	var body = document.getElementsByTagName("body")[0];
    window.setInterval(blink1, 1000, body);
}

function blink1(body) {
	body.style.backgroundColor = "rgba(0, 0, 39, 0.9)";
    window.setTimeout(blink2, 500, body);
}

function blink2(body) {
	var firstColor = Math.floor(Math.random() * 256);
    var secondColor = Math.floor(Math.random() * 256);
    var thirdColor = Math.floor(Math.random() * 256);
	body.style.backgroundColor = "rgb(" + firstColor + ", " + secondColor + ", " + thirdColor + ")";
}