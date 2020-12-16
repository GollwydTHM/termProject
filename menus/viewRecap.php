<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/viewRecap.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
            .btnCell {
                background-color: white;
                border-top: 1px solid white;
                border-right: 1px solid white;
                border-bottom: 1px solid white;
                padding-top: 0px !important;
                padding-bottom: 0px !important;
            }
            .btnCell:hover {
                background-color: white;
            }
            .cellBtn {
                margin: 0px;
            }
            .hidden {
                visibility: hidden;
            }
        </style>
    </head>
    <body>
        <h1>Tournament Game List</h1>
        <p><i>Click on a game for recap option.</i></p>

        <button id="btnView">View Games</button>


        <table>
            <tr>
                <th>Game ID</th>
                <th>Match ID</th>
                <th>Game Number</th>
                <th>Game State ID</th>
                <th>Score</th>
                <th>Ball</th>
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
    </body>
</html>