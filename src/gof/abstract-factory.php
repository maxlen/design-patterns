<?php

/**
 * Задача: Написать программу, используя паттерн Abstract Factory (Абстрактная фабрика)
 * https://refactoring.guru/ru/design-patterns/abstract-factory
 *
 *  Кафе, специализирующегося на нескольких национальных кухнях
 *  Каждая кухня сдержит традиционные блюда
 *  Готовим комплексные обеды – для японской, американской и украинской кухни
 *
 *  Решение на 83-й строке
 */

interface KitchenFactoryInterface
{
    public function createFood();
}

abstract class KitchenAbstract
{
    protected FoodInterface $food;

    public function getTasteOfFood(): void
    {
        $this->food->getTaste();
    }
}

class UkraineKitchenFactory extends KitchenAbstract implements KitchenFactoryInterface
{
    public function createFood()
    {
        $this->food = new UkraineFood();
    }
}

class AmericaKitchenFactory extends KitchenAbstract implements KitchenFactoryInterface
{
    public function createFood()
    {
        $this->food = new AmericaFood();
    }
}

class JapanKitchenFactory extends KitchenAbstract implements KitchenFactoryInterface
{
    public function createFood()
    {
        $this->food = new JapanFood();
    }
}

class UkraineFood implements FoodInterface
{
    public function getTaste(): void
    {
        echo 'Taste of ukrainian food';
    }
}

class AmericaFood implements FoodInterface
{
    public function getTaste(): void
    {
        echo 'Taste of american food';
    }
}

class JapanFood implements FoodInterface
{
    public function getTaste(): void
    {
        echo 'Taste of japanning food';
    }
}

interface FoodInterface
{
    public function getTaste();
}


// Client code:
$kitchen = new UkraineKitchenFactory();
$kitchen->createFood();
$kitchen->getTasteOfFood();
echo PHP_EOL;