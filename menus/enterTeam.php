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
        if (isset($_POST['btnGetStats'])) {
            $_SESSION["teamID"]= $_POST['ID'];
            header('location: viewStats.php');
        }
        
        ?>
        
        <h1>Team ID</h1>
        <form action="" method="POST">
            <input type="number" name="ID" required>
        <button id="btnGetStats" name="btnGetStats">View Statistics</button>
        </form>
        </table>
    </body>
</html>