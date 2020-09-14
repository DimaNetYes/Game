<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 08.06.2020
 * Time: 15:43
 */

namespace Models\Times;

use Services\Db;
use Models\ActiveRecordEntity;

class Time extends ActiveRecordEntity
{

    private const TABLE_NAME = 'time';

    public static function saveTime($time)
    {
        $db = Db::getInstance();
        $db->query(
            'INSERT INTO ' . self::TABLE_NAME . ' (time) VALUES (:time)',
            [
                'time' => $time
            ]
        );
        //Второй вариант
//        $time = new Time($time);
//        $time->save();
    }

    protected static function getTableName(): string  //Избавились от зависимОсти таблийы в findAll
    {
        return 'time';
    }



}