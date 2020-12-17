<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/guestTeams.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Teams</h2>
        <p id="notice">Click on a team for view player option.</p>

        <button id="btnView">Refresh</button>       

        <table>
            <tr>
                <th>Team ID</th>
                <th>Team Name</th>
                <th>Earnings</th>
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
    </body>
</html>