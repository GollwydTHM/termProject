<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>Project - Bowling Tournament</title>
        <!--<script src="../js/matchups.js"></script>-->
        <!--<link rel="stylesheet" href="../mainStyleSheet.css">-->
        <style>
            table tr th td {
                border-colllapse: collapse;
            }
            /*            table {
                            background-image: url("../graphics/pokemon_battle.jpg");
                            background-size: cover;
                        }*/
            button {
                margin-bottom: 10px;
            }
            #qualContainer {
                margin: auto 0px;
                border: 2px solid #444444;
                background-color: #dddddd;
                width: 92vw;
            }
            ol {
                -webkit-column-count: 5; -webkit-column-gap:20px;
                -moz-column-count:5; -moz-column-gap:20px;
                -o-column-count: 5; -o-column-gap:20px;
                column-count: 5; column-gap:20px;
                list-style-position: inside;
            }
            ol li:not(:nth-child(1n + 17)) {
                font-weight: bold;
            }
            ol li:nth-child(1n + 17) {
                color: #888888;
            }
            table tbody tr th td {
                padding: 0px;
            }
            table {
                display: table;
            }
            tbody {
                width: calc(92vw / 9);
                display: inline-block;
            }
            .seedGame {
                color: green;
            }
            .randGame {
                color:purple;
                text-align: right;
            }

            td {
                vertical-align: bottom;
                width: calc(90vw / 9);
                border-bottom: 2px solid black;
            }
            .seedGame tr:nth-child(2n + 0) td {
                border-right: 2px solid black;
            }
            .randGame tr:nth-child(2n + 0) td {
                border-left: 2px solid black;
            }

            tr:first-child {
                height: 50px;
            }
            /*SEED1 && RAND1*/
            tbody:first-child tr,
            tbody:last-child tr {
                height: 50px;
            }
            /*SEED2 && RAND2*/
            tbody:nth-child(2) tr:not(:first-child),
            tbody:nth-child(8) tr:not(:first-child){
                height: 102px;
            }
            /*SEED3 && RAND3*/
            tbody:nth-child(3) tr:not(:first-child),
            tbody:nth-child(7) tr:not(:first-child){
                height: 206px;
            }
            /*SEED4 && RAND4*/
            tbody:nth-child(4) tr:not(:first-child),
            tbody:nth-child(6) tr:not(:first-child) {
                height: 415px;
            }
            /*FINAL*/
            tbody:nth-child(5) tr:not(:first-child) {
                color: purple;
            }
            tbody:nth-child(5) tr:not(:first-child) td {
                border: none;
                text-align: right;
                vertical-align: top;
            }
        </style>
    </head>
    <body>
        <h1>Tournament Standings</h1>

        <button id="btnView">View Standings</button>
        <div id="qualContainer">
            <ol>
                <li>Just</li>
                <li>a Trial</li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ol>
        </div>

        <table id="tblSeeded">
            <tbody id="colSeed1" class="seedGame">
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
            </tbody>
            <tbody id="colSeed2" class="seedGame">
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>               
            </tbody>
            <tbody id="colSeed3" class="seedGame">
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>                
            </tbody>
            <tbody id="colSeed4" class="seedGame">
                <tr><td></td></tr>
                <tr><td></td></tr>             
            </tbody>
            <tbody id="colFinal" class="seedGame">
                <tr><td></td></tr>
                <tr><td></td></tr>  
            </tbody>
            <tbody id="colRand4" class="randGame">
                <tr><td></td></tr>
                <tr><td></td></tr>             
            </tbody>
            <tbody id="colRand3" class="randGame">
                <tr><td></td></tr>
                <tr><td></td></tr>  
                <tr><td></td></tr>
                <tr><td></td></tr>    
            </tbody>
            <tbody id="colRand2" class="randGame">
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>    
                <tr><td></td></tr>
                <tr><td></td></tr>    
                <tr><td></td></tr>
                <tr><td></td></tr>    
            </tbody>
            <tbody id="colRand1" class="randGame">
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>    
                <tr><td></td></tr>
                <tr><td></td></tr>    
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>    
                <tr><td></td></tr>
                <tr><td></td></tr>    
                <tr><td></td></tr>
                <tr><td></td></tr>
            </tbody>
        </table>
    </body>
</html>