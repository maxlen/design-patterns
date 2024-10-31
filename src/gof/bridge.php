<?php

/**
 * GoF Adapter https://refactoring.guru/ru/design-patterns/bridge
 *
 * Написать программу, используя паттерн Bridge.
 *
 * Расширяем и изменяем программу кафе, используя паттерн Bridge:
 *  - Готовим блюдо определенной кухни
 *  - Первое, второе, третье и десерт
 *
 *  Решение на 80-й строке
 */

interface KitchenFactoryInterface
{
    public function createFood(FoodInterface $food);

    public function getTasteOfFood(): void;
}

abstract class KitchenAbstract
{
    protected FoodInterface $food;

    public function createFood(FoodInterface $foodType)
    {
        $this->food = $foodType;
    }

    public function getTasteOfFood(): void
    {
        $this->food->getTaste();
    }
}

class UkraineKitchenFactory extends KitchenAbstract implements KitchenFactoryInterface
{
    public function getTasteOfFood(): void
    {
        echo $this->food->getTaste() . ' (ukrainian type of food)';
    }
}

class JapanKitchenFactory extends KitchenAbstract implements KitchenFactoryInterface
{
    public function getTasteOfFood(): void
    {
        echo $this->food->getTaste() . ' (japanese type of food)';
    }
}

interface FoodInterface
{
    public function getTaste(): string;
}

class FoodPervoye implements FoodInterface
{
    public function getTaste(): string
    {
        return "Taste of pervoye bludo";
    }
}

class FoodVtoroe implements FoodInterface
{
    public function getTaste(): string
    {
        return "Taste of vtoroye bludo";
    }
}

class FoodDesert implements FoodInterface
{
    public function getTaste(): string
    {
        return "Taste of desert";
    }
}

// Client Code получаем первое блюдо украинской кухни
$kitchen = new UkraineKitchenFactory();
$kitchen->createFood(new FoodPervoye());
$kitchen->getTasteOfFood();

echo PHP_EOL;
$kitchen->createFood(new FoodDesert());
$kitchen->getTasteOfFood();

echo PHP_EOL;

