<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <!--<script src="mainMenu.js"></script>-->
        
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Guest Menu</h1>
        <form action="viewTeams.php">
            <button type="submit" id="btnViewTeams">View Teams and Statistics</button>
        </form>
        <form action="matchups.php">
            <button type="submit">Tournament Standings</button>
        </form>
    </body>
</html>