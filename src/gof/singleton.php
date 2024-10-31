<?php

/**
 * Написать программу, используя паттерн Singleton (Одиночка).
 * https://refactoring.guru/ru/design-patterns/singleton
 *
 * Создайте класс, допускающий создание не более 10 экземпляров себя и хранящий ссылки на все эти экземпляры
 *
 *  Решение на 34-й строке
 */

class Singleton
{
    private static $instances = [];

    private function __construct() { }

    protected function __clone() {}

    public static function getInstance($instanceName): Singleton
    {
        if (!isset(self::$instances[$instanceName])) {
            if (count(self::$instances) == 10) {
                throw new Exception('Max count of instances reached 10 items');
            }

            self::$instances[$instanceName] = new static();
        }

        return self::$instances[$instanceName];
    }
}

// Client code
for ($i = 1; $i <= 10; $i++) {
    $singleton[$i] = Singleton::getInstance('instance_' . $i);
}

var_dump($singleton);
$singleton10 = Singleton::getInstance('instance_10');
var_dump($singleton10);

// try to create instance number 11:
$singleton = Singleton::getInstance('instance_11');

echo PHP_EOL;

