<?php

/**
 * Написать реализацию шаблона GoF Factory Method (Фабричный метод):
 * https://refactoring.guru/ru/design-patterns/factory-method
 *
 * Печь для приготовления еды
 * Готовит разные блюда, в  зависимости от поступающих параметров
 *
 * Решение на 56-й строке
 */

const DISH_FISH = 'fish';
const DISH_SALAD = 'salad';

class OvenFactory implements OvenInterface
{
    public function createDish(string $dishName): DishInterface {

        if (!in_array($dishName, [DISH_FISH, DISH_SALAD])) {
            throw new \Exception('incompatible dishName');
        }

        return match ($dishName) {
            DISH_FISH => new FishDish(),
            DISH_SALAD => new FishDish()
        };
    }
}

interface OvenInterface {
    public function createDish(string $dishName): DishInterface;
}

class FishDish implements DishInterface
{
    public function getSmell(): void
    {
        echo 'Smell of fish';
    }
}

class SalaвDish implements DishInterface
{
    public function getSmell(): void
    {
        echo 'Smell of salad';
    }
}

interface DishInterface
{
    public function getSmell();
}

$oven = new OvenFactory();
$dish = $oven->createDish('fish');
$dish->getSmell();