var numbers = [];
var isCellSelected = false;
var cellSelected;

var easterEggPassword = "30ELODE";
var index = 0;

window.addEventListener("load", initialize, false);
window.addEventListener("keypress", checkEasterEgg, false);

function checkEasterEgg(keyPressed) {
    var charPressed = checkChar(keyPressed);
    findEgg(charPressed);
}

function findEgg(charPressed) {
    if(charPressed == easterEggPassword[index++]) {
        if(index >= easterEggPassword.length) {
            finishGame();
        }
    } else {
        index = 0;
    }
}

function finishGame() {
    for(var i = 1; i <= 16; i++) {
        var cell = document.getElementById("cell" + i);
        if(i == 16) {
            cell.innerHTML = "";
            cell.setAttribute("class", "emptyCell");
        } else {
            cell.removeAttribute("class");
            cell.innerHTML = i;
        }
    }
    checkWin();
}

function checkChar(key) {
    var charCode = key.keyCode;
    return String.fromCharCode(charCode);
}

function initialize() {
    document.getElementById("resetButton").addEventListener("click", resetGame, false);
    startGame();
}

function startGame() {
    for (var i = 1; i <= 16; i++) {
        var cellValue = Math.floor(Math.random() * 16);
        while (isPresent(cellValue)) {
            cellValue = Math.floor(Math.random() * 16);
        }
        numbers[cellValue] = true;
        var cell = document.getElementById("cell" + i);
        cell.addEventListener("click", selectCell, false);
        if (cellValue == 0) {
            cell.innerHTML = "";
            cell.setAttribute("class", "emptyCell");
        } else {
            //Nel caso in cui il gioco venga riavviato, ogni classe deve essere azzerata
            cell.removeAttribute("class");
            cell.innerHTML = cellValue;
        }
    }
}

function isPresent(index) {
    return numbers[index] ? true : false;
}

function resetGame() {
    numbers = [];
    startGame();
}

function selectCell() {
    var cell = this;
    if (!isCellSelected) {
        if (cell.classList.contains("emptyCell")) {
            cellSelected = cell;
            isCellSelected = true;
            cell.classList.add("selectedCell");
        } else {
            window.alert("Come prima cella puoi selezionare solo la cella vuota.");
        }
    } else if (cell == cellSelected) {
        cellSelected = null;
        isCellSelected = false;
        cell.classList.remove("selectedCell");
    } else {
        var cellID = cell.id;
        var effectiveID = parseInt(cellID.substring(4, 6));
        if (isGranted(effectiveID)) {
            cell.classList.add("emptyCell");
            cellSelected.classList.remove("emptyCell");
            var temp = cell.innerHTML;
            cell.innerHTML = cellSelected.innerHTML;
            cellSelected.innerHTML = temp;
            cellSelected.classList.remove("selectedCell");
            cellSelected = null;
            isCellSelected = false;
            checkWin();
        } else {
            window.alert("Selezionare solo una cella adiacenta alla cella già selezionata.");
        }
    }
}

function isGranted(id) {
    var result;
    var existentEffectiveID = parseInt(cellSelected.id.substring(4, 6));
    //Se la cella selezionata è la successiva o precedente in termini orizzontali o verticali allora si puo' selezionare
    if (id == existentEffectiveID - 4 || id == existentEffectiveID + 4 || id == existentEffectiveID + 1 || id == existentEffectiveID - 1) {
        result = true;
    } else {
        result = false;
    }
    return result;
}

function removeEventListeners() {
    for (var i = 1; i <= 16; i++) {
        var cell = document.getElementById("cell" + i);
        cell.removeEventListener("click", selectCell, false);
    }
}

function checkWin() {
    var result = true;
    var i = 1;
    while (i <= 15 && result) {
        var actualValue = parseInt(document.getElementById("cell" + i).innerHTML);
        var nextValue = parseInt(document.getElementById("cell" + (i + 1)).innerHTML);
        if (!isFinite(actualValue) || actualValue > nextValue) {
            result = false;
        } else {
            i++;
        }
    }
    if(result) {
        removeEventListeners();
        window.alert("Complimenti!");
        //Tutto per passare parametri POST
        // Create a form
        var mapForm = document.createElement("form");
            
        mapForm.method = "POST";
        mapForm.action = "/finish.php";

        // Create an input
        var mapInput = document.createElement("input");
       
        mapInput.type = "text";
        mapInput.name = "control";
        mapInput.value = "DONE!";

        // Add the input to the form
        mapForm.appendChild(mapInput);

        // Add the form to dom
        document.body.appendChild(mapForm);

        // Just submit
        mapForm.submit();
        //window.location.href = "/finish.php";
    }
}