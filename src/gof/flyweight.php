<?php

/**
 * GoF Flyweight - https://refactoring.guru/ru/design-patterns/flyweight
 *
 * Написать программу, используя паттерн Flyweight:
 *
 * Напишите программу, поддерживающую работу с двумя типами юнитов компьютерной игры
 * (танки и пехота или пехота и кавалерия) так, чтобы можно было включать разнородные юниты
 * в единый список (создание армии) и изменять их координаты одновременно (перемещение армии).
 * Причем так, чтобы тяжелые данные каждого юнита - текстура и звуки хранились в памяти
 * только один раз для одного типа юнитов.
 *
 *  Решение на 131-й строке
 */

class UnitSoldiersStateParamsSingleton
{
    public $texture = 'soldier texture';
    public $sounds = 'soldier sounds';
    
    private static $instance = null;

    private function __construct() { }

    protected function __clone() {}

    public static function getInstance(): UnitSoldiersStateParamsSingleton
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}

class UnitCavalryStateParamsSingleton
{
    public $texture = 'cavalry texture';
    public $sounds = 'cavalry sounds';

    private static $instance = null;

    private function __construct() { }

    protected function __clone() {}

    public static function getInstance(): UnitCavalryStateParamsSingleton
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}

interface UnitItem
{
    function setCoordinates(string $coordinates);
}

class UnitSoldiers implements UnitItem
{
    public UnitSoldiersStateParamsSingleton $unit;
    public $soldiersCoordinates;

    public function __construct()
    {
        $this->unit = UnitSoldiersStateParamsSingleton::getInstance();
    }

    public function setCoordinates(string $coordinates): void
    {
        $this->soldiersCoordinates = $coordinates;
    }
}

class UnitCavalry implements UnitItem
{
    public UnitCavalryStateParamsSingleton $unit;
    public $cavalryCoordinates;

    public function __construct()
    {
        $this->unit = UnitCavalryStateParamsSingleton::getInstance();
    }

    public function setCoordinates(string $coordinates): void
    {
        $this->cavalryCoordinates = $coordinates;
    }
}

class Army
{
    private array $units;

    public function addUnit(UnitItem $unit): void
    {
        $this->units[] = $unit;
    }

    public function getUnits(): array
    {
        return $this->units;
    }

    public function changeUnitCoordinates(UnitItem $unit, $coordinates): void
    {
        $unit->setCoordinates($coordinates);
    }

    public function changeAllUnitsCoordinates($coordinates): void
    {
        foreach ($this->units as $unit) {
            $unit->setCoordinates($coordinates);
        }
    }

    public function printAllUnits()
    {
        foreach ($this->units as $unit) {
            print_r($unit);
        }
    }
}

/** Client code */
$army = new Army();
$army->addUnit(new UnitSoldiers());
$army->addUnit(new UnitCavalry());

$army->changeAllUnitsCoordinates('10 x 20');
$army->printAllUnits(); // print different units same coordinates

$army->addUnit(new UnitCavalry());
$army->changeUnitCoordinates($army->getUnits()[0], '5 x 10'); // for UnitSoldiers
$army->changeUnitCoordinates($army->getUnits()[1], '30 x 35'); // for UnitCavalry1
$army->changeUnitCoordinates($army->getUnits()[2], '1 x 1'); // for UnitCavalry2
$army->printAllUnits(); // print different units with different coordinates

echo PHP_EOL;

