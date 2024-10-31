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
 *  Решение на 184-й строке
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

    public function __construct(Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    abstract public function execute();

    abstract function undo();
}

class AddCheeseCommand extends Command
{
    public function execute()
    {
        $this->pizza->cheese++;
        return $this;
    }

    public function undo(): self
    {
        $this->pizza->cheese--;

        return $this;
    }
}

class AddBaconCommand extends Command
{
    public function execute()
    {
        $this->pizza->bacon++;
        return $this;
    }

    public function undo(): self
    {
        $this->pizza->bacon--;
        return $this;
    }
}

class AddPineappleCommand extends Command
{
    public function execute()
    {
        $this->pizza->pineapple++;
        return $this;
    }

    public function undo(): self
    {
        $this->pizza->pineapple--;
        return $this;
    }
}

class AddMushroomCommand extends Command
{
    public function execute()
    {
        $this->pizza->mushroom++;
        return $this;
    }

    public function undo(): self
    {
        $this->pizza->mushroom--;
        return $this;
    }
}

class AddSeafoodCommand extends Command
{
    public function execute()
    {
        $this->pizza->seafood++;
        return $this;
    }

    public function undo(): self
    {
        $this->pizza->seafood--;
        return $this;
    }
}

class Application
{
    public Pizza $pizza;

    public array $commandHistory = [];

    public function preparePizza()
    {
        $this->pizza = new Pizza();

        return $this;
    }

    public function addIngredient($ingredientName)
    {
        switch ($ingredientName) {
            case CHEESE:
                (new AddCheeseCommand($this->pizza))->execute();
                array_push($this->commandHistory, AddCheeseCommand::class);
                break;
            case BACON:
                (new AddBaconCommand($this->pizza))->execute();
                array_push($this->commandHistory, AddBaconCommand::class);
                break;
            case PINEAPPLE:
                (new AddPineappleCommand($this->pizza))->execute();
                array_push($this->commandHistory, AddPineappleCommand::class);
                break;
            case MUSHROOM:
                (new AddMushroomCommand($this->pizza))->execute();
                array_push($this->commandHistory, AddMushroomCommand::class);
                break;
            case SEAFOOD:
                (new AddSeafoodCommand($this->pizza))->execute();
                array_push($this->commandHistory, AddSeafoodCommand::class);
                break;
        }

        return $this;
    }

    public function undo()
    {
        /** @var Command $ingredientCommand */
        $ingredientCommand = array_pop($this->commandHistory);
        (new $ingredientCommand($this->pizza))->undo();

        return $this;
    }

    public function getResult(): Pizza
    {
        return $this->pizza;
    }
}

# Client code
$application = new Application();
$application = $application->preparePizza()
    ->addIngredient(CHEESE)
    ->addIngredient(CHEESE)
    ->addIngredient(BACON)
    ->addIngredient(MUSHROOM);

echo PHP_EOL . 'Cooked pizza:' . PHP_EOL;
print_r($application->getResult()); // print pizza with: 2 cheese, 1 bacon, 1 mushroom
echo PHP_EOL;

$application->undo()->undo();
print_r($application->getResult()); // print pizza with: 2 cheese
echo PHP_EOL;