<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src=""></script>

        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Welcome</h1>
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