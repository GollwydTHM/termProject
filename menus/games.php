<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/games.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Scorekeeper > Games to Score</h2>
        <p id="notice">Click on a game for scoring option.</p>

        <button id="btnView">View Games</button>
        <form method="POST" action="../menus/scoreMenu.php" class="inline">
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