<?php
namespace DB;
Class Database {

    private $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return $this
     */
    protected function connect()
    {
        $host = 'localhost';
        $db_name = 'rest_api';
        $username = 'root';
        $password = '';
        $charset = 'utf8';

        $dsn = 'mysql:host='.$host.';dbname='.$db_name.';charset='.$charset;

        $opt = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );

        $this->pdo = new \PDO( $dsn, $username, $password, $opt );

        return $this;
    }


    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}