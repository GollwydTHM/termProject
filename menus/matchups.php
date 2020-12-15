<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/matchups.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Tournament Matchup List</h1>

        <button id="btnView">View Matchups</button>
        

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

