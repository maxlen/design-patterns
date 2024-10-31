<?php

/**
 * GoF Facade - https://refactoring.guru/ru/design-patterns/facade
 *
 * Написать программу, используя паттерн Facade:
 *
 * Создайте Facade в вашем языке программирования для этого веб-сервиса: http://www.dneonline.com/calculator.asmx
 *
 *  Решение на 84-й строке
 */

abstract class Service
{
    protected $baseUrl; // http url
}

class ServiceAdd extends Service {
    public function calculate(int $a, int $b): int
    {
        return $a + $b; // or go to $this->baseUrl/add
    }
}

class ServiceDivide {
    public function calculate(int $a, int $b): int
    {
        return round($a / $b); // or go to $this->baseUrl/divide
    }
}

class ServiceMultiply {
    public function calculate(int $a, int $b): int
    {
        return $a * $b; // or go to $this->baseUrl/multiply
    }
}

class ServiceSubtract {
    public function calculate(int $a, int $b): int
    {
        return $a - $b; // or go to $this->baseUrl/substract
    }
}

interface FacadeMathInterface
{
    public function add(int $a, int $b);

    public function devide(int $a, int $b);

    public function multiply(int $a, int $b);

    public function subtract(int $a, int $b);
}

class FacadeMath implements FacadeMathInterface
{

    public function add(int $a, int $b)
    {
        return (new ServiceAdd())->calculate($a, $b);
    }

    public function devide(int $a, int $b)
    {
        return (new ServiceDivide())->calculate($a, $b);
    }

    public function multiply(int $a, int $b)
    {
        return (new ServiceMultiply())->calculate($a, $b);
    }

    public function subtract(int $a, int $b)
    {
        return (new ServiceSubtract())->calculate($a, $b);
    }
}

/**
 * Client code
 */
echo (new FacadeMath())->add(1, 1) . PHP_EOL; // выведет на экран 2
echo (new FacadeMath())->subtract(6, 1) . PHP_EOL; // выведет на экран 5
echo (new FacadeMath())->multiply(2, 2) . PHP_EOL; // выведет на экран 4
echo (new FacadeMath())->devide(6, 2) . PHP_EOL; // выведет на экран 3

echo PHP_EOL;

