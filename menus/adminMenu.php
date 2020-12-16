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
        <h2>Admin</h2>
        <form action="viewTeamsCRUD.php">
            <button type="submit" id="btnViewTeams" class="btnMenu btnMenuTop">View Teams</button>
        </form>
        <form action="viewPlayersCRUD.php">
            <button type="submit" id="btnViewTeams" class="btnMenu">View Players</button>
        </form>
        <form action="generateRankings.php">
            <button type="submit" class="btnMenu">Generate Rankings</button>
        </form>
        <form action="generateMatchups.php">
            <button type="submit" class="btnMenu">Generate Matchups</button>
        </form>
        <form method="POST" action="../index.php">
            <button type="submit" class="btnMenu">&larrhk; Return to index &nbsp;&nbsp;&nbsp;</button>
        </form>
    </body>
</html>