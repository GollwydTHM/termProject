<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <!--<script src="mainMenu.js"></script>-->
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Guest</h2>
        <form action="viewTeams.php">
            <button type="submit" id="btnViewTeams" class="btnMenu btnMenuTop">View Teams</button>
        </form>
        <form action="enterTeam.php">
            <button type="submit" id="btnStatistics" class="btnMenu">View Statistics</button>
        </form>
        <form action="viewTourData.php">
            <button type="submit" class="btnMenu">View Tournament Data</button>
        </form>
        <form action="matchups.php">
            <button type="submit" class="btnMenu">Tournament Standings</button>
        </form>
        <form action="viewRecap.php">
            <button type="submit" id="btnViewRecap" class="btnMenu">View Recap</button>
        </form>
        <form action="viewPayouts.php">
            <button type="submit" id="btnViewPayouts" class="btnMenu">View Payouts</button>
        </form>
        <form method="POST" action="../index.php">
            <button type="submit" class="btnMenu">&larrhk; Return to index &nbsp;&nbsp;&nbsp;</button>
        </form>
    </body>
</html>