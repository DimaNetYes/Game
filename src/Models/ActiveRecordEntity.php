<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 24.06.2020
 * Time: 16:07
 */
//Тут общие методы, которые можно использовать любым классом

namespace Models;
use Services\Db;

abstract class ActiveRecordEntity
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return static|null
     * Возвращает одну статью по id
     */
    public static function getById(int $id): ?self
    {
        $db = DB::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function __set($name, $value)
    {
//        echo 'Пытаюсь задать для свойства ' . $name . ' значение ' . $value . '<br>';
        $this->$name = $value;  //При неизвестном свойстве из бд, добавится.
    }


    public static function findAll(): array  //Статический метод ACtive Record
    {
        $db = DB::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class); //Позднее статическое связывание. Для класса наследника
    }

        //Возвращает запись по определенному столбцу
    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if ($result === []) {
            return null;
        }
        return $result[0];

    }
                                //4 Функции связаны
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        //здесь мы обновляем существующую запись в базе
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        //здесь мы создаём новую запись в базе
        $filteredProperties = array_filter($mappedProperties); //clean all null value
        $columns = [];
        foreach($filteredProperties as $columnName => $value){
            $columns[] = '`' . $columnName . '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
//        var_dump($sql); //Ниже подставим параметры
        $db = DB::getInstance();
        $db->query($sql, $params2values, static::class); //подставляем параметры
        $this->id = $db->getLastInsertId();
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }

            ///////////////////////////////////////////Конец связи

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    abstract protected static function getTableName(): string;

}