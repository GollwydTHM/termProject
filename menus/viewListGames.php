<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/listGames.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
    </head>
    <body>
        <?php
        session_start();
        $teamID = $_POST['teamID']; 
        ?>
        <h1>Bowling Tournament</h1> 
        <button id="btnList">View Games List</button>
        <input id="teamID" value="<?php echo $teamID; ?>" hidden>
        <form method="POST" action="viewTourData.php" class="inline">
            <button type="submit">&larr; Go Back</button>
        </form>
        
        <table class="listGames">
            <tr>
                <th>Game ID</th>
                <th>Match ID</th>
                <th>Game Number</th>
                <th>Team ID</th> 
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
    </body>
</html>
