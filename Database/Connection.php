<?php

namespace Database;

class Connection
{
    const HOST = '127.0.0.1';
    const DB_NAME = 'library';
    const USERNAME = 'root';
    const PASSWORD = '';

    protected $connection;

    public function __construct()
    {
        $this->connection = new \PDO('mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME, self::USERNAME, self::PASSWORD);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function destroy()
    {
        $this->connection = null;
    }
}