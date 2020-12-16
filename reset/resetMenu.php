<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="reset.js"></script>

        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Reset Menu</h1>
        <form method="POST">
            <button name="btnInitial" id="btnInitial" type="submit">Reset to initial state</button>
        </form>
        
        <form method="POST" action="../index.php">
            <button type="submit">Return to index</button>
        </form>
    </body>
</html>