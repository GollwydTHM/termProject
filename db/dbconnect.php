<?php

class DBConnect {

    function connect_db() {
        $db = new PDO("mysql:host=localhost;dbname=bowlingtournament;port=3306", "neil", "neil");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

}