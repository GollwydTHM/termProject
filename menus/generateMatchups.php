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
        <form>
            <select id="rounds" name="rounds">                
                <option value="SEED1" selected="selected">SEED1</option>
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
        <button id="btnView" type="submit">View Rankings</button>
        <button id="btnMatch" type="submit">Generate Matchups</button>
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