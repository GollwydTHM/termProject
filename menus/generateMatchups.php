<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <script src="../js/generateMatchups.js"></script>
        <link rel="stylesheet" href="../mainStyleSheet.css">
        <style>
            button {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Bowling Tournament</h1>
        <h2>Admin Menu > Generate Matchups</h2>
<!--        <form action="setMatchups.php" method="POST">
            <button id="btnSEED1" type="submit">SEED1</button>
            <input type="hidden" value="" id="SEED1" name="SEED1">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnSEED2" type="submit">SEED2</button>
            <input type="hidden" value="" id="SEED2" name="SEED2">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnSEED3" type="submit">SEED3</button>
            <input type="hidden" value="" id="SEED3" name="SEED3">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnSEED4" type="submit">SEED4</button>
            <input type="hidden" value="" id="SEED4" name="SEED4">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnRAND1" type="submit">RAND1</button>
            <input type="hidden" value="" id="RAND1" name="RAND">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnRAND2" type="submit">RAND2</button>
            <input type="hidden" value="" id="RAND2" name="RAND2">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnRAND3" type="submit">RAND3</button>
            <input type="hidden" value="" id="RAND3" name="RAND3">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnRAND4" type="submit">RAND4</button>
            <input type="hidden" value="" id="RAND4" name="RAND4">
        </form>
        <form action="setMatchups.php" method="POST">
            <button id="btnFINAL" type="submit">FINAL</button>
            <input type="hidden" value="" id="FINAL" name="FINAL">
        </form>-->
        <form>
            select a round to generate from:
            <select id="rounds" name="rounds">                
                <option value="QUAL" selected="selected">QUAL</option>
                <option value="SEED1">SEED1</option>
                <option value="SEED2">SEED2</option>
                <option value="SEED3">SEED3</option>
                <option value="SEED4">SEED4</option>
                <option value="RAND1">RAND1</option>
                <option value="RAND2">RAND2</option>
                <option value="RAND3">RAND3</option>
                <option value="RAND4">RAND4</option>
                <option value="FINAL">FINAL</option>
            </select> 
           
        </form>
        <button id="btnView" type="submit">View Round Status</button>
        <button id="btnRank" type="submit">Generate Matchups for next round</button>
        <table>
            <tr>
                <th>Match ID</th>
                <th>Round ID</th>
                <th>Match Group</th>
                <th>Team ID</th>
                <th>Score</th>
                <th>Ranking</th>

            </tr>
            <tbody id="recordRows">
            </tbody>
        </table>
    </body>
</html>