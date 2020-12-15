<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/adminPlayers.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Players</h1>
        <button id="btnGet">Get Data</button>
        <button id="btnAdd">Add Player</button>
        <button id="btnUpdate" disabled>Update Player</button>
        <button id="btnDelete" disabled>Delete Player</button>

        <div id="AddUpdatePanel" class="hidden">
            <div> 
                <div>
                    <div>Player ID</div><input id="inputID" required>
                </div>
                <div>
                    <div>Team ID</div><input id="inputTeamID" required>
                </div>
                <div>
                    <div>First Name</div><input id="inputFirstName" type="text" required>
                </div>
                <div>
                    <div>Last Name</div><input id="inputLastName" type="text" required>
                </div>
                <div>
                    <div>Hometown</div><input id="inputHometown" type="text" required>
                </div>
                <div>
                    <div>Province Code</div><input id="inputProvinceCode" type="text" required>
                </div>
            </div>
            <div>
                <button id="btnOK">OK</button>
                <button id="btnCancel">Cancel</button>
            </div>
        </div>

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