<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <!--<script src="mainMenu.js"></script>-->

        <style>
            button {
                width: 175px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Admin Menu</h1>
        <form action="viewTeamsCRUD.php">
            <button type="submit" id="btnViewTeams">View Teams</button>
        </form>
        <form action="viewPlayersCRUD.php">
            <button type="submit" id="btnViewTeams">View Players</button>
        </form>
        <form action="generateRankings.php">
            <button type="submit">Generate Rankings</button>
        </form>
        <form action="generateMatchups.php">
            <button type="submit">Generate Matchups</button>
        </form>
        <form method="POST" action="../index.php">
            <button type="submit">&larrhk; Return to index &nbsp;&nbsp;&nbsp;</button>
        </form>
    </body>
</html>