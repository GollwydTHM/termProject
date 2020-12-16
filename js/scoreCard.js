let balls = "";
let ballVals = [];
let gameStateID = "";
let theFrame;
let theThrow;
let bonusBalls = 2;
let complete = false;

window.onload = function () {
    //get current ball value from record (only runs once in onload)
    InitializeGame();
    //fill the card with any values already in balls string (from InProgress game)
    FillCard();

    //EVENT HANDLERS
    document.querySelector("#btnAdd").addEventListener("click", AddToBalls);
    document.querySelector("#btnUndo").addEventListener("click", UndoLastMessage);
    document.querySelector("#btnBack").addEventListener("click", PrevPage);
};

function PrevPage() {
    window.history.back();
}

function InitializeGame() {
    balls = document.querySelector("#gameBalls").value.replace(/\s+/g, "");
    gameStateID = document.querySelector("#gameStateID").value;
    //console.log(balls);
}

function FillCard() {
    theFrame = 0;
    theThrow = 0;
    let ballRow = document.querySelector("#ballRow").querySelectorAll("td");
    for (let i = 0; i < balls.length; i++) {
        if (theThrow === 0) {
            ballRow[theFrame + 1].innerHTML = balls[i];
            if (balls[i] === "X") {
                if (theFrame !== 10) {
                    theFrame++;
                } else {
                    theThrow++;
                }
            } else {
                theThrow++;
            }
        } else if (theThrow === 1) {
            ballRow[theFrame + 1].innerHTML += balls[i];
            theFrame++;
            theThrow--;
        }
    }
    BuildBallValues();

    //will be passing these values at end of this method to UpdateGame()
    let score = CalcScores();

    //declare what frame and throw the user is about to enter a value for
    let frameDisplay = "Bonus";
    if (theFrame < 10) {
        frameDisplay = "Frame " + (theFrame + 1);
    }
    document.querySelector("#frameThrowDisplay").innerHTML =
            frameDisplay + ", Throw " + (theThrow + 1) + ":";

    if (theFrame >= 10) {
        CheckComplete();
    }

    score = CalcScores();
    UpdateGame(score);
    updateMatchup();
}

// Takes ball string and builds an array of numbers, where X = 10 and / = 10 - previous num
function BuildBallValues() {
    ballVals = []; //new array
    for (let i = 0; i < balls.length; i++) {
        if (balls[i] === "X") {
            ballVals.push(10);
        } else if (balls[i] === "/") {
            ballVals.push(10 - parseInt(balls[i - 1]));
        } else {
            ballVals.push(parseInt(balls[i]));
        }
    }
}

function CalcScores() {
    let ballFrames = document.querySelector("#ballRow").querySelectorAll("td");
    let scoreFrames = document.querySelector("#scoreRow").querySelectorAll("td");
    let ballMap = balls.split("");
//    console.log(ballVals);
//    console.log(ballMap);
    frameScore = [];
    for (let i = 0; i < 11; i++) {
        frameScore.push(0);
    }
    counter = 0; //to scan through ballMap and ballVals arrays
    for (let i = 1; i < 11; i++) { //loop through each frame (bonus ball frame doesn't have own score)
        let tempScore = 0;
        let secondVal = true; //use this to skip getting second value in case of 'X' strike

        if (ballVals[counter] !== "undefined") {
            if (ballMap[counter] === "X") { //IF STRIKE
                tempScore += ballVals[counter++];
                if (typeof ballVals[counter] !== "undefined") {
                    tempScore += ballVals[counter];
                    if (typeof ballVals[counter + 1] !== "undefined") {
                        tempScore += ballVals[counter + 1];
                    }
                }
                secondVal = false;
            } else {
                tempScore += ballVals[counter++]; //NOT A STRIKE
            }
            if (!isNaN(tempScore)) {
                frameScore[i] = tempScore;
                scoreFrames[i].innerHTML = tempScore;
            }
        }

        if (secondVal === true && ballVals[counter] !== "undefined") {
            if (ballMap[counter] === "/") { //IF SPARE
                tempScore += (10 - ballVals[counter - 1]);
                counter++;
                if (typeof ballVals[counter] !== "undefined") {
                    tempScore += ballVals[counter];
                }
            } else { //NOT A SPARE
                tempScore += ballVals[counter++];
            }
            if (!isNaN(tempScore)) {
                frameScore[i] = tempScore;
                scoreFrames[i].innerHTML = tempScore;
            }
        }
    }

    //running total of frame scores placed into total scores row;
    let runningTotal = 0;
    let sendScore = 0;
    let ttlScoreFrames = document.querySelector("#ttlScoreRow").querySelectorAll("td");
    for (let i = 1; i < scoreFrames.length; i++) {
        if (!isNaN(parseInt(scoreFrames[i].innerHTML))) {
            runningTotal += parseInt(scoreFrames[i].innerHTML);
            ttlScoreFrames[i].innerHTML = runningTotal;
        }
    }
    return runningTotal; //this is the current game score
}

function AddToBalls() {
    //console.log(gameStateID);
    if (gameStateID === "AVAILABLE" || gameStateID === "INPROGRESS") {
        //place focus back on textbox
        document.querySelector("#ballValue").focus();

        let input = document.querySelector("#ballValue").value;

        if (input.match("[^0-9xX\/]")) { //if entered value isn't valid character, stop function
            document.querySelector("#inputErr").innerHTML = "\"" + input + "\" is not a valid character!";
            document.querySelector("#ballValue").value = "";
            document.querySelector("#inputErr").classList.remove("hidden");
            return;
        }
        //remove error msg
        document.querySelector("#inputErr").classList.add("hidden");

        if (bonusBalls === 2 || bonusBalls === 1) {
            if (input !== "") { //skip if input value non-existent
                //should the input be a lowercase 'x', make it upper (looks nicer)
                if (input === "x") { //
                    input = "X";
                }
                if (theThrow === 0) { //FIRST THROW
                    if (input !== "/") { //cant be a spare
                        balls += input;
                        document.querySelector("#ballValue").value = "";
                    } else {
                        document.querySelector("#inputErr").innerHTML = "Cannot throw a spare on your first throw!";
                        document.querySelector("#inputErr").classList.remove("hidden");
                    }
                }
                if (bonusBalls === 2) {
                    if (theThrow === 1) { //SECOND THROW
                        if (input !== "X") { //cant be a strike
                            if (parseInt(balls[balls.length - 1]) + parseInt(input) > 10) {
                                document.querySelector("#inputErr").innerHTML = "Cannot score more than 10 in a frame!";
                                document.querySelector("#inputErr").classList.remove("hidden");
                            } else {
                                //if user inputs 2nd throw equalling 10 change val to "/", else add input to string
                                if (parseInt(balls[balls.length - 1]) + parseInt(input) === 10) {
                                    input = "/";
                                }
                                balls += input;
                                document.querySelector("#ballValue").value = "";
                            }
                        } else {
                            if (theFrame === 10) {
                                balls += input; //can only get strike in second throw in bonus frame!
                            } else {
                                document.querySelector("#inputErr").innerHTML = "Cannot throw a strike on your second throw!";
                                document.querySelector("#inputErr").classList.remove("hidden");
                            }
                        }
                    }
                }
            }
            //end of ball input
            FillCard();
        }
    }
}

function UndoLastMessage() {
    if (complete === false) {
        if (confirm('Would you like to UNDO the last entered value (' + (balls[balls.length - 1]) + ')?')) {
            UndoLast();
        }
    }
}

function UndoLast() {
    balls = balls.slice(0, -1);
    ResetCard();
    FillCard();
}

function ResetCard() {
    let ballFrames = document.querySelector("#ballRow").querySelectorAll("td");
    let scoreFrames = document.querySelector("#scoreRow").querySelectorAll("td");
    let ttlScoreFrames = document.querySelector("#ttlScoreRow").querySelectorAll("td");
    for (let i = 1; i <= 11; i++) {
        ballFrames[i].innerHTML = "";
        scoreFrames[i].innerHTML = "";
        ttlScoreFrames[i].innerHTML = "";
    }
}

function CheckComplete() {
    let gameComplete = false;

    let frameTen = document.querySelector("#ballRow").querySelectorAll("td")[10];
    let bonusFrame = document.querySelector("#ballRow").querySelectorAll("td")[11];
    frameTen = frameTen.innerHTML.split("");
    bonusFrame = bonusFrame.innerHTML.split("");
    if (frameTen.length === 1) { //got stike in tenth frame
        if (frameTen[0] === "X" && bonusFrame.length === 2) {
            gameComplete = true;
        }
    } else {
        if (frameTen[1] === "/" && bonusFrame.length === 1) {
            gameComplete = true;
        } else if (parseInt(frameTen[1]) >= 0 && parseInt(frameTen[1]) < 10) {
            gameComplete = true;
        }
    }
    if (gameComplete === true && gameStateID !== "COMPLETE") {
        if (confirm('ATTENTION: The last entered value (' + balls[balls.length - 1] + ') will end the game!\n\n' +
                'Are you certain there are no user errors?\n' +
                '"OK": Game is complete, no further changes can be made!\n' +
                '"Cancel": the last entered value will be removed.')) {
            //lock all inputs
            document.querySelector("#ballValue").disabled = true;
            document.querySelector("#btnAdd").disabled = true;
            document.querySelector("#btnUndo").disabled = true;
            //declare games completion
            document.querySelector("#frameThrowDisplay").innerHTML =
                    "Game Complete!";
            gameStateID = "COMPLETE";
            updateMatchup();
        } else {
            UndoLast();
        }
    }
}

function UpdateGame(score) {
    let gameID = Number(document.querySelector("#gameID").value);
    let matchID = Number(document.querySelector("#matchID").value);
    let gameNumber = Number(document.querySelector("#gameNumber").value);

    //confirm gameState
    if (gameStateID !== "COMPLETE") {
        if (balls === "") {
            gameStateID = "AVAILABLE";
        } else {
            gameStateID = "INPROGRESS";
        }
    } else {
        //lock all inputs
        document.querySelector("#ballValue").disabled = true;
        document.querySelector("#btnAdd").disabled = true;
        document.querySelector("#btnUndo").disabled = true;
    }

    console.log("gameID--->" + gameID + " is a " + typeof gameID);
    console.log("matchID--->" + matchID + " is a " + typeof matchID);
    console.log("gameNumber--->" + gameNumber + " is a " + typeof gameNumber);
    console.log("gameStateID--->" + gameStateID + " is a " + typeof gameStateID);
    console.log("score--->" + score + " is a " + typeof score);
    console.log("balls--->" + balls + " is a " + typeof balls);

    //validation successful, create team object
    let obj = {
        "gameID": gameID,
        "matchID": matchID,
        "gameNumber": gameNumber,
        "gameStateID": gameStateID,
        "score": score,
        "balls": balls
    };

    //determine the directory for AJAX call
    let url = "gameService/games/" + gameID;

    //AJAX
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            if (resp.search("ERROR") >= 0 || resp != "1") {
                console.log(resp);
                alert("Error occered when PUT");
            } else {
                //alert("Updated!");
            }
        }
    };
    xmlhttp.open("PUT", url, true);
    xmlhttp.send(JSON.stringify(obj));
}

function updateMatchup() {
    let matchID = Number(document.querySelector("#matchID").value);

    let url = "matchupService/matchup/ScoreMatch/" + matchID;

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            let resp = xmlhttp.responseText;
            if (resp.search("ERROR") >= 0 || resp != "1") {
                console.log(resp);
                alert("Error occered when PUT");
            } else {
                //alert("Updated!");
            }
        }
    };
    xmlhttp.open("PUT", url, true);
    xmlhttp.send();
}