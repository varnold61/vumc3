<?php

/**
 * Class dbHandler- handles etting up the mysql connection using pdo
 */
class dbHandler
{
     /* Connect to a MySQL database using driver invocation */
    /*private $dsn = 'mysql:dbname=repos;host=127.0.0.1';
    private $user = 'root';
    private $password = '';
    */
    /**
     * @var string  $dsn - the db connection string
     */
    private $dsn = 'mysql:dbname=repos;host=varnold.powwebmysql.com';

    /**
     * @var string  $user - the database username
     */
    private $user = 'virginia';

    /**
     * @var string  $password -the db password
     */
    private $password = 'mypass123';

    /**
     * @var \PDO $dbh - the handle
     */
    protected  $dbh; // connection handler

    /**
     * dbHandler constructor.- establis the connection
     */
    public function __construct()
    {
        try
        {
            $this->dbh = new PDO($this->dsn, $this->user, $this->password);
        }  catch (PDOException $e) {
                echo( 'Connection failed: ' . $e->getMessage());
                return false;
        }

        //$this->dbh =  $dbh;
        return true;
    }

    /**
     * @return \PDO - handle to the atabase connection
     */
    public function getDbh() {
        return $this->dbh;
    }

}

