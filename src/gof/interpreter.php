<?php

/**
 * Паттерн Интерпретатор (Interpreter) определяет представление грамматики для заданного языка и интерпретатор
 * предложений этого языка. Как правило, данный шаблон проектирования применяется для часто повторяющихся операций.
 *
 * https://bool.dev/blog/detail/povedencheskie-patterny-interpretator-csharp
 * https://github.com/RefactoringGuru/design-patterns-php/blob/main/src/RefactoringGuru/Interpreter/RealWorld/index.php
 *
 * Интерпретатор следует использовать когда вам  необходимо интерпретировать запись в другом языке и тд. Как один из
 * примеров может служить перевод римских цифр в арабские.
 *
 * Расширяем програму Command добавляя обработку кастомного рецепта в виде строки:
 * Предыдущая задача по Command:
 * Готовим пиццу.
 * По кастомному рецепту от пользователя содержащему в разных сочетаниях:
 *  - Сыр
 *  - Бекон
 *  - Ананасы
 *  - Грибы
 *  - Морепродукты
 *
 *  Решение на 111-й строке
 */

require_once 'command2.php';

interface ExpressionIterface
{
    public function interpret(string $context);
}
class Expression implements ExpressionIterface
{
    public function interpret(string $context)
    {
        // разбиваем строку на команды (слова)
        $words = explode(' ', $context);

        $pizza = new Pizza();

        foreach ($words as $ingredientName) {
            switch ($ingredientName) {
                case CHEESE:
                    $command = (new AddCheeseExpression())->getCommand($pizza);
                    break;
                case BACON:
                    $command = (new AddBaconExpression())->getCommand($pizza);
                    break;
                case PINEAPPLE:
                    (new AddPineappleExpression())->getCommand($pizza);
                    break;
                case MUSHROOM:
                    (new AddMushroomExpression())->getCommand($pizza);
                    break;
                case SEAFOOD:
                    (new AddSeafoodExpression())->getCommand($pizza);
                    break;
            }

            /** @var Command */
            $command->execute();
        }

        return $pizza;
    }

    public function getCommand(Pizza $pizza) {}
}

class AddCheeseExpression extends Expression
{
    public function getCommand(Pizza $pizza): AddCheeseCommand
    {
        return new AddCheeseCommand($pizza);
    }
}

class AddBaconExpression extends Expression
{
    public function getCommand(Pizza $pizza): AddBaconCommand
    {
        return new AddBaconCommand($pizza);
    }
}

class AddPineappleExpression extends Expression
{
    public function getCommand(Pizza $pizza): AddPineappleCommand
    {
        return new AddPineappleCommand($pizza);
    }
}

class AddSeafoodExpression extends Expression
{
    public function getCommand(Pizza $pizza): AddSeafoodCommand
    {
        return new AddSeafoodCommand($pizza);
    }
}

class AddMushroomExpression extends Expression
{
    public function getCommand(Pizza $pizza): AddMushroomCommand
    {
        return new AddMushroomCommand($pizza);
    }
}


# Client code
$inputContext = 'cheese bacon cheese';
$expression = new Expression();

// Prepared pizza
print_r($expression->interpret($inputContext));
//will print pizza with 2 cheese and 1 bacon