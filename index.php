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
        <form method="POST" action="menus/guestMenu.php" class="menuForm">
            <img src="graphics/user.svg" class="menuIcon">
            <button name="guest" type="submit" class="btnMenu btnMenuTop">Guest Login</button>
        </form>
        <form method="POST" action="menus/games.php" class="menuForm">
            <img src="graphics/whistle.svg" class="menuIcon">
            <button name="scorekeeper" type="submit" class="btnMenu">Scorekeeper Login</button>
        </form>
        <form method="POST" action="menus/adminMenu.php" class="menuForm">
            <img src="graphics/settings.svg" class="menuIcon">
            <button name="admin" type="submit" class="btnMenu">Admin Login</button>
        </form>
        <form method="POST" action="reset/resetMenu.php" class="menuForm">
            <img src="graphics/refresh.svg" class="menuIcon">
            <button name="reset" type="submit" class="btnMenu">Reset Database Sets</button>
        </form>
    </body>
</html>