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
         
        <form action="viewTourData.php">
            <button type="submit" class="btnMenu">Team/Player Statistics</button>
        </form>
        <form action="matchups.php">
            <button type="submit" class="btnMenu">Tournament Standings</button>
        </form>
         
        <form method="POST" action="../index.php">
            <button type="submit" class="btnMenu">&larrhk; Return to index &nbsp;&nbsp;&nbsp;</button>
        </form>
    </body>
</html>