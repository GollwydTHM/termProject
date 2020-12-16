<!DOCTYPE html>
<?php
require_once '../db/PlayerAccessor.php';
require_once '../entity/Player.php';
require_once '../utils/ChromePhp.php';
?>
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
        <table>
            <tr>
                <th>Team ID</th>
                <th>Player ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Hometown</th>
                <th>Province Code</th>
            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
        <?php
        //make teamID accessible to JS
        session_start();
        $teamID = $_POST["teamID"];
        ?>
        <input type="hidden" id="teamID" value="<?php echo $teamID; ?>">
    </body>
</html>