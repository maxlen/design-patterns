<?php

/**
 * Задача на GoF шаблон Prototype (Прототип):
 * https://refactoring.guru/ru/design-patterns/prototype
 *
 * Создайте класс автомобиль, имеющий три разных предустановленных варианта (легковой, грузовой и минивен),
 * позволяющий изменение только полей цвет и номер
 *
 * Внимание - не три класса,а  один, просто с тремя предустановленными вариантами.
 *
 * Метод клон не должен вызываться из клиентского кода. Наоборот - должны быть предоставлены методы,
 * позволяющие создавать разные типы
 *
 *  Решение на 82-й строке
 */

class CarType
{
    const LEGKOVOY = 'legkovoy';
    const GRUZOVOY = 'gruzovoy';
    const MINIVEN = 'miniven';

    private string $name;
    private string $color;
    private string $carNumber;

    public function __construct(string $name, string $color = 'default color', string $carNumber = 'default carNumber')
    {
        if (!in_array($name, [self::LEGKOVOY, self::GRUZOVOY, self::MINIVEN])) {
            throw new Exception("Invalid name '$name'");
        }

        $this->name = $name;
        $this->color = $color;
        $this->carNumber = $carNumber;
    }

    public function clone(string $color, string $carNumber): self
    {
        $clone = new CarType($this->name);
        $clone->color = $color;
        $clone->carNumber = $carNumber;

        return $clone;
    }

    public function printAllParameters(): void
    {
        print_r($this);
    }
}

class Car
{
    public array $carTypes;

    public function createCarTypes()
    {
        $this->carTypes = [
            CarType::LEGKOVOY => new CarType(CarType::LEGKOVOY),
            CarType::GRUZOVOY => new CarType(CarType::GRUZOVOY),
            CarType::MINIVEN => new CarType(CarType::MINIVEN),
        ];

        return $this->carTypes;
    }

    public function createCarType(string $name, string $color, string $carNumber): CarType
    {
        if (!in_array($name, [CarType::LEGKOVOY, CarType::GRUZOVOY, CarType::MINIVEN])) {
            throw new Exception("Invalid name '$name'");
        }

        $newCarType = $this->carTypes[$name]->clone($color, $carNumber);

        return $newCarType;
    }
}

// client code
$car = new Car();
$carTypes = $car->createCarTypes();
$newClonnedCarType = $car->createCarType(CarType::GRUZOVOY, 'yellow', 'AP 7230 CH');

$carTypes[CarType::GRUZOVOY]->printAllParameters();
echo PHP_EOL;

print_r('Clonned carType:' . PHP_EOL);
$newClonnedCarType->printAllParameters();

