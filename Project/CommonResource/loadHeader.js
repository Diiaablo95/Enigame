var anchor = document.createElement("a");
anchor.href = "/index.php";
var header = document.createElement("header");
anchor.classList.add("flex-container");
header.classList.add("roundedCorners");
var imgDiv = document.createElement("div");
imgDiv.id = "logoDiv";
imgDiv.classList.add("flex-centered");
var logoImg = document.createElement("img");
logoImg.src = "/CommonResource/enigame_logo.png";
logoImg.alt = "Enigame logo";

imgDiv.appendChild(logoImg);
logoImg.style.width = "100%";
logoImg.style.height = "100%";
header.appendChild(imgDiv);
anchor.appendChild(header);
document.getElementsByTagName("body")[0].appendChild(anchor);