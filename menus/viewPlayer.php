<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/guestPlayers.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Players</h1>

        <button id="btnView">View All Teams </button>
        

        <table>
            <tr>
                <th>Player ID</th>
                <th>Team ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Hometown</th>
                <th>Province Code</th>
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
    </body>
</html>