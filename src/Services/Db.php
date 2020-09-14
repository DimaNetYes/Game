<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 23.06.2020
 * Time: 12:09
 */

namespace Services;

class Db
{
    private $pdo;
    private static $instance; //Singletone

    private function __construct()
    {
        $dbOptions = (require_once __DIR__ . '/../setting.php' )['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getInstance(): self  //SINGLETON
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className); //Задает свойствам класса в модели, значения из бд
    }
        //Получение последнего id
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}