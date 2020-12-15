<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/adminTeams.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Team Name</h1>
        <button id="btnGet">Get Data</button>
        <button id="btnAdd">Add Team</button>
        <button id="btnUpdate" disabled>Update Team</button>
        <button id="btnDelete" disabled>Delete Team</button>
        <div id="AddUpdatePanel" class="hidden">
            <div> 
                <div>
                    <div>Team ID</div><input id="inputID" required>
                </div>
                <div>
                    <div>Title</div><input id="inputTeamName" type="text" required>
                </div>
                <div>
                    <div>Earnings</div><input id="inputEarnings" type="number" min = "0" required>
                </div>
            </div>
            <div>
                <button id="btnOK">OK</button>
                <button id="btnCancel">Cancel</button>
            </div>
        </div>

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