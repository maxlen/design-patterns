<?php

/**
 * Написать программу, используя паттерн Command (Команда).
 * https://refactoring.guru/ru/design-patterns/command
 * Команда — это поведенческий паттерн проектирования, который превращает запросы в объекты, позволяя передавать
 * их как аргументы при вызове методов, ставить запросы в очередь, логировать их, а также поддерживать отмену операций.
 *
 * Готовим пиццу.
 * По кастомному рецепту от пользователя содержащему в разных сочетаниях:
 *  - Сыр
 *  - Бекон
 *  - Ананасы
 *  - Грибы
 *  - Морепродукты
 *
 *  Решение на 119-й строке
 */

const CHEESE = 'cheese';
const BACON = 'bacon';
const PINEAPPLE = 'pineapple';
const MUSHROOM = 'mushroom';
const SEAFOOD = 'seafood';

class Pizza
{
    // тут можно было сделать Get-терами и Set-терами, но решил сэкономить пространство и просто сделать публичными св-ми
    public int $cheese = 0;
    public int $bacon = 0;
    public int $pineapple = 0;
    public int $mushroom = 0;
    public int $seafood = 0;
}

abstract class Command
{
    protected Pizza $pizza;

    protected array $params = [];

    abstract public function execute(Pizza $object, array $params);
    abstract public function getResult(): Pizza;
}

class PreparePizzaCommand extends Command
{
    public function execute(Pizza $object, array $params)
    {
        $this->pizza = $object;
        $this->params = $params;

        foreach ($this->params as $ingredient => $quantity) {
            switch ($ingredient) {
                case CHEESE:
                    $this->addCheese($quantity);
                    break;
                case BACON:
                    $this->addBacon($quantity);
                    break;
                case PINEAPPLE:
                    $this->addPineapple($quantity);
                    break;
                case MUSHROOM:
                    $this->addMushroom($quantity);
                    break;
                case SEAFOOD:
                    $this->addSeafood($quantity);
                    break;
            }
        }
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

# Client code
$command = new PreparePizzaCommand();
$command->execute(new Pizza, [CHEESE => 2, PINEAPPLE => 1]);

echo PHP_EOL . 'Cooked pizza:' . PHP_EOL;
print_r($command->getResult());
echo PHP_EOL;
