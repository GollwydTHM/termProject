<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/viewRecap.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            h1 {
                margin-bottom: 0px;
            }
            #notice {
                margin-top: 0px;
                font-style: italic;
            }
            button {
                display: inline-block;
                margin-bottom: 10px;
            }
            form {
                display: inline-block;
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
        <p id="notice">Click on a game for scoring option.</p>

        <button id="btnView">View Games</button>
        <form method="POST" action="../menus/guestMenu.php">
            <button type="submit">&larr; Go Back</button>
        </form>

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