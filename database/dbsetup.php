<?php
    require 'config.php';

    // Should return a PDO
    function db_connect() {

        try {

            //$connectionString = "mysql:dbhost=" . DBHOST . "; dbname =" . DBNAME;
            $dbuser = DBUSER;
            $dbpass = DBPASS;
            $dsn = DSN;

            $options = array(PDO::ATTR_PERSISTENT =>true);

            $pdo = new PDO($dsn, $dbuser, $dbpass, $options);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        }

        catch (PDOException $e) {
            
            die($e->getMessage());
        }
}