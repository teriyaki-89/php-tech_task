<?php

//defined('Site_Name') or exit( 'access denied');

Class DB {

    /*public function __construct($localhost = NULL, $dbname = NULL, $username = NULL, $password = NULL)
    {
        $localhost = $localhost ? $localhost : 'localhost';
        $dbname = $dbname ? $dbname : 'test_db';
        $username = $username ? $username : 'root';
        $password = $password ? $password : '03091989';
        //R::setup( "mysql:host=$localhost;dbname=$dbname;charset=utf8", $username, $password);
        //R::freeze( TRUE );

        $conn = mysqli_connect($localhost, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    }*/
    private static $instance = NULL;
    public function __construct() {}


    public static function getInstance($localhost = NULL, $dbname = NULL, $username = NULL, $password = NULL) {
        if (!isset(self::$instance)) {
            $localhost = $localhost? $localhost:'localhost';
            $dbname = $dbname? $dbname:'test_db';
            $username = $username? $username:'root';
            $password = $password? $password:'03091989';
            $pdo_options = [
                PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
            ];

            try{
                self::$instance = new pdo( 'mysql:host='.$localhost.';dbname='.$dbname.';charset=utf8',
                    $username,
                    $password,
                    $pdo_options);
            }
            catch(PDOException $ex){
                die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
            }
        }
        return self::$instance;
    }



}



?>