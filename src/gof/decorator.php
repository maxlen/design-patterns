<?php

/**
 * GoF Decorator https://refactoring.guru/ru/design-patterns/decorator
 *
 * Написать программу, используя паттерн Decorator:
 *
 * Готовим пиццу
 * По кастомному рецепту от пользователя содержащему в разных сочетаниях:
 * - Сыр
 * - Бекон
 * - Ананасы
 * - Грибы
 * - Морепродукты
 *
 *  Решение на 78-й строке
 */

interface Recipe
{
    public function addToRecipe();
}

class ConcreteRecipe implements Recipe
{
    public function addToRecipe()
    {
        echo 'Preparing recipe... ';
    }
}

class BaseDecorator implements Recipe
{
    public Recipe $subject;

    public function __construct(Recipe $subject)
    {
        $this->subject = $subject;
    }

    public function addToRecipe() {
        $this->subject->addToRecipe();
    }
}

class RecipeWithCheeseDecorator extends BaseDecorator
{
    public function addToRecipe()
    {
        parent::addToRecipe();
        echo '+1 Cheese to recipe, ';
    }
}

class RecipeWithBaconDecorator extends BaseDecorator
{
    public function addToRecipe()
    {
        parent::addToRecipe();
        echo '+1 Bacon to recipe, ';
    }
}

class RecipeWithPineappleDecorator extends BaseDecorator
{
    public function addToRecipe()
    {
        parent::addToRecipe();
        echo '+1 Pineapple to recipe, ';
    }
}

/** Client code
 *
 * Выводит на экран:
 * Preparing recipe... +1 Pineapple to recipe, +1 Bacon to recipe, +1 Cheese to recipe,
 */
$recipe = new RecipeWithCheeseDecorator(new RecipeWithBaconDecorator(new RecipeWithPineappleDecorator(new ConcreteRecipe())));

$recipe->addToRecipe();
echo PHP_EOL;

