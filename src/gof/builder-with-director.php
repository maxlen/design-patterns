<?php

/**
 * Написать программу, используя паттерн Builder (Строитель).
 * https://refactoring.guru/ru/design-patterns/builder
 *
 * Готовим пиццу.
 * По кастомному рецепту от пользователя содержащему в разных сочетаниях:
 *  - Сыр
 *  - Бекон
 *  - Ананасы
 *  - Грибы
 *  - Морепродукты
 *
 *  Решение на 96-й строке
 */

interface Builder
{
    public function reset();
    public function getResult();
    public function addCheese(int $quantity);
    public function addBacon(int $quantity);
    public function addPineapple(int $quantity);
    public function addMushroom(int $quantity);
    public function addSeafood(int $quantity);
}

class Pizza
{
    // тут можно было сделать Get-терами и Set-терами, но решил сэкономить пространство и просто сделать публичными св-ми
    public int $cheese = 0;
    public int $bacon = 0;
    public int $pineapple = 0;
    public int $mushroom = 0;
    public int $seafood = 0;
}

class PizzaBuilder implements Builder
{
    private Pizza $pizza;

    public function reset() {
        $this->pizza = new Pizza();
    }

    public function getResult(): Pizza
    {
        return $this->pizza;
    }

    public function addCheese(int $quantity): void
    {
        $this->pizza->cheese = $quantity;
    }

    public function addBacon(int $quantity): void
    {
        $this->pizza->bacon = $quantity;
    }

    public function addPineapple(int $quantity): void
    {
        $this->pizza->pineapple = $quantity;
    }

    public function addMushroom(int $quantity): void
    {
        $this->pizza->mushroom = $quantity;
    }

    public function addSeafood(int $quantity): void
    {
        $this->pizza->seafood = $quantity;
    }
}

class Director
{
    public function cookCheesePizza(Builder $builder): void
    {
        $builder->reset();
        $builder->addCheese(4);
        $builder->addMushroom(2);
    }

    public function cookSeaPizza(Builder $builder): void
    {
        $builder->reset();
        $builder->addSeafood(5);
        $builder->addPineapple(1);
    }


}

// client code
$director = new Director();
$builder = new PizzaBuilder();
$director->cookCheesePizza($builder);
$cookedPizza = $builder->getResult();

echo PHP_EOL . 'Cooked pizza:' . PHP_EOL;

print_r($cookedPizza);

echo PHP_EOL;

