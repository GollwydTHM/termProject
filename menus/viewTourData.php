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
        <h1>List of Teams</h1>
        
         
        <div>
            <button id="btnView">Get Data</button>
        </div>
        <div>
            <button id="btnTopRank">View Top 16</button>
        </div>
        <table>
            <tr>
                <th>Team ID</th>
                <th>Team Name</th>
                <th>Score</th>
                <th>Ranking</th>
                
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
 
    </body>
</html>