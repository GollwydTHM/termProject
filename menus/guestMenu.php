<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <!--<script src="mainMenu.js"></script>-->

        <style>
            button {
                width: 175px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Guest Menu</h2>
        <form action="viewTeams.php">
            <button type="submit" id="btnViewTeams">View Teams</button>
        </form>
        <form action="enterTeam.php">
            <button type="submit" id="btnStatistics">View Statistics</button>
        </form>

        <form action="viewPlayers.php">
            <button type="submit" id="btnViewPlayers">View Players</button>
        </form>

        <form action="matchups.php">
            <button type="submit">Tournament Standings</button>
        </form>
        <form action="viewRecap.php">
            <button type="submit" id="btnViewRecap">View Recap</button>
        </form>
        <form action="viewPayouts.php">
            <button type="submit" id="btnViewPayouts">View Payouts</button>
        </form>
        <form method="POST" action="../index.php">
            <button type="submit">&larrhk; Return to index &nbsp;&nbsp;&nbsp;</button>
        </form>
    </body>
</html>