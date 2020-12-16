<!DOCTYPE html>
<?php
require 'utils/chromePhp.php';
?>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="js/scoreCard.js"></script>

        <style>
            .title {
                margin-bottom: 0px;
            }
            .subtitle {
                margin-top: 0px;
            }
            .lightWeight {
                font-weight: 300;
                color: #666666;
            }
            table, tr, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            table {
                margin: 20px 0px;
            }
            th:not(:first-child) {
                background-color: #dddddd;
            }
            th:first-child {
                border-top: 1px solid white;
                border-left: 1px solid white;
            }
            table tr:nth-child(1n+3) td:last-child {
                border-bottom: 1px solid white;
                border-right: 1px solid white;
            }
            th, td {
                height: 20px;
                min-width: 35px;
                padding: 5px;
            }
            #ballRow td:not(:first-child) {
                text-align: left;
                letter-spacing: 4px;
                padding-left: 10px;
                padding-right: 0px;
            }
            td:not(:first-child) {
                font-family: monospace;
                font-size: 1.2em;
                text-align: center;
            }
            tr td:first-child {
                font-weight: bold;
                background-color: #dddddd;
            }
            #ballValue {
                width: 50px;
            }
            #inputErr {
                margin-left: 5px;
                font-style: italic;
                color: red;
            }
            .hidden {
                display: none;
            }
            button {
                width: 85px;
            }
            #btnUndo {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        // get post superglobal values (gameID and gameBalls)
        $gameID = $_POST['gameID'];
        $matchID = $_POST['matchID'];
        $gameNumber = $_POST['gameNumber'];
        $gameStateID = $_POST['gameStateID'];
        $gameBalls = $_POST['gameBalls'];
        ?>
        <input type="hidden" id="gameID" value="<?php echo $gameID ?>">
        <input type="hidden" id="matchID" value="<?php echo $matchID ?>">
        <input type="hidden" id="gameNumber" value="<?php echo $gameNumber ?>">
        <input type="hidden" id="gameStateID" value="<?php echo $gameStateID ?>">
        <input type="hidden" id="gameBalls" value="<?php echo $gameBalls ?>">

        <h1 class="title">Bowling Tournament</h1>
        <h2 class="subtitle">
            Game ID: <span class="lightWeight"><?php echo $gameID; ?></span> 
            Status: <span id="subtitleGameState" class="lightWeight"><?php echo $gameStateID; ?></span></h2>
        <span id="frameThrowDisplay"></span> <input id="ballValue" type="text" maxlength="1">
        <button type="submit" id="btnAdd">Enter Value</button><span id="inputErr" class="hidden"></span>
        <table>
            <tr>
                <th></th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>Bonus</th>
            </tr>
            <tr id="ballRow">
                <td>Balls</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="scoreRow">
                <td>Frame</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr id="ttlScoreRow">
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <button type="submit" id="btnUndo">Undo Last</button>
        <button type="submit" id="btnBack">&larr; Go Back</button>
    </body>
</html>