<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src=""></script>

        <style>
            h1 {
                margin-bottom: 0px;
            }
            h2 {
                margin-top: 0px;
            }
            button {
                width: 175px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Main Menu</h2>
        <form method="POST" action="menus/guestMenu.php">
            <button name="guest" type="submit">Guest Login</button>
        </form>
        <form method="POST" action="menus/scoreMenu.php">
            <button name="scorekeeper" type="submit">Scorekeeper Login</button>
        </form>
        <form method="POST" action="menus/adminMenu.php">
            <button name="admin" type="submit">Admin Login</button>
        </form>
        <form method="POST" action="reset/resetMenu.php">
            <button name="reset" type="submit">Reset Database Sets</button>
        </form>
    </body>
</html>