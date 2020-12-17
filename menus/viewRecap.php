<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/viewRecap.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
    </head>
    <body>
        <h1>Tournament Game List</h1>
        <p id="notice">Click on a game for scoring option.</p>

        <button id="btnView">Refresh</button>
        <form method="POST" action="../menus/guestMenu.php" class="inline">
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