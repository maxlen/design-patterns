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
 *  Решение на 90-й строке
 */

class Pizza
{
    // тут можно было сделать Get-терами и Set-терами, но решил сэкономить пространство и просто сделать публичными св-ми
    public int $cheese = 0;
    public int $bacon = 0;
    public int $pineapple = 0;
    public int $mushroom = 0;
    public int $seafood = 0;
}

interface Builder
{
    public function build(): self;
    public function getResult(): Pizza;
    public function addCheese(int $quantity): self;
    public function addBacon(int $quantity): self;
    public function addPineapple(int $quantity): self;
    public function addMushroom(int $quantity): self;
    public function addSeafood(int $quantity): self;
}

class PizzaBuilder implements Builder
{
    private Pizza $pizza;

    public function build(): self
    {
        $this->pizza = new Pizza();

        return $this;
    }

    public function getResult(): Pizza
    {
        return $this->pizza;
    }

    public function addCheese(int $quantity): self
    {
        $this->pizza->cheese = $quantity;

        return $this;
    }

    public function addBacon(int $quantity): self
    {
        $this->pizza->bacon = $quantity;

        return $this;
    }

    public function addPineapple(int $quantity): self
    {
        $this->pizza->pineapple = $quantity;

        return $this;
    }

    public function addMushroom(int $quantity): self
    {
        $this->pizza->mushroom = $quantity;

        return $this;
    }

    public function addSeafood(int $quantity): self
    {
        $this->pizza->seafood = $quantity;

        return $this;
    }
}

# Cook Cheese Pizza
$builder = new PizzaBuilder();
$cookedPizza = $builder->build()->addCheese(4)->addMushroom(2)->getResult();

echo PHP_EOL . 'Cooked pizza:' . PHP_EOL;

print_r($cookedPizza);

echo PHP_EOL;
