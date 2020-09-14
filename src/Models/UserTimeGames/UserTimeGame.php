<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 08.06.2020
 * Time: 16:06
 */
namespace Models\UserTimeGames;

use Models\ActiveRecordEntity;
use Services\Db;

class UserTimeGame extends ActiveRecordEntity
{

    private const TABLE_NAME = 'user_time_games';
    public $id;

    public static function saveUserTimeGame(string $user_id, string $time, $game)
    {
        $db = Db::getInstance();

        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . 'user_id' . '` = :value LIMIT 1;',
            [':value' => $user_id],
            static::class
        );

        if ($result === []) {
            $db->query(
                'INSERT INTO ' . self::TABLE_NAME . ' (user_id, time_id, game_id) VALUES (:user, :time, :game)',
                [
                    'user' => $user_id,
                    'time' => $time,
                    'game' => $game
                ]
            );
        }else{
            $sql = 'UPDATE ' . self::TABLE_NAME . ' SET user_id = ' . $user_id . ', time_id = ' . "'$time'" . ', game_id = 1 WHERE id = ' . $result[0]->id;
            $db->query(
                $sql
            );
//            print_r($result[0]->id);
//            return $sql;
        }
    }

    public function getAllTime()
    {
        $db = Db::getInstance();
       return $db->query("SELECT id, time_id FROM " . static::getTableName() . ";", [], static::class);
    }


    protected static function getTableName(): string
    {
        return "user_time_games";
    }
}