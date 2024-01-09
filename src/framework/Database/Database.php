<?php

declare(strict_types=1);

namespace Morloax\Framework\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class Database
{
    protected static \Doctrine\DBAL\Connection $conn;
    protected static \Doctrine\DBAL\Query\QueryBuilder $query;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => DB_NAME,
            'user' => DB_USERNAME,
            'password' => DB_PASSWORD,
            'host' => DB_HOST,
            'driver' => DB_DRIVER,
            'port' => DB_PORT
        ];


        try {
            self::$conn = DriverManager::getConnection($connectionParams);
            self::$query = self::$conn->createQueryBuilder();
        } catch (Exception $e) {
            die($e);
        }
    }
}