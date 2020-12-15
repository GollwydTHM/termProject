<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/guestStats.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
         
        
        
        <?php
        session_start();
        $teamID = $_SESSION['teamID'];
        echo '<h1>Statistics for the team ' . $teamID . '</h1>';
        echo "<input id='teamID' value='" . $teamID . "' hidden>";
        ?> 
        <div>
            <button id="btnView">Get Data</button>
        </div>
        <table>
            <tr>
                <th>Match ID</th>
                <th>Round ID</th>
                <th>Match Group</th>
                <th>Team ID</th>
                <th>Score</th>
                <th>Ranking</th>
                
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
 
    </body>
</html>