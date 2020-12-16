<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <link rel="stylesheet" href="mainStyleSheet.css">
        
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Main Menu</h2>
        <form method="POST" action="menus/guestMenu.php">
            <button name="guest" type="submit" class="btnMenu btnMenuTop">Guest Login</button>
        </form>
        <form method="POST" action="menus/scoreMenu.php">
            <button name="scorekeeper" type="submit" class="btnMenu">Scorekeeper Login</button>
        </form>
        <form method="POST" action="menus/adminMenu.php">
            <button name="admin" type="submit" class="btnMenu">Admin Login</button>
        </form>
        <form method="POST" action="reset/resetMenu.php">
            <button name="reset" type="submit" class="btnMenu">Reset Database Sets</button>
        </form>
    </body>
</html>