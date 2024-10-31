<?php

/**
 * Strategy — это поведенческий паттерн проектирования, который определяет семейство схожих алгоритмов и помещает
 * каждый из них в собственный класс, после чего алгоритмы можно взаимозаменять прямо во время исполнения программы.
 *
 * https://refactoring.guru/ru/design-patterns/strategy
 *
 * Написать программу, используя паттерн Strategy:
 * - Сортировщик списка
 * - Стратегии
 * - Пузырьковая сортировка
 * - Быстрая сортировка
 *
 *  Решение на 74-й строке
 */

interface Strategy
{
    public function sort(array $data): array;
}

class BubbleSortStrategy implements Strategy
{
    public function sort(array $data): array
    {
        echo PHP_EOL . "Sorting by bubble sort ... ";

        for ($i = count($data) - 1; $i > 0; $i--) {
            $swap = false;

            for ($j = 0; $j < $i; $j++) {
                if ($data[$j] > $data[$j + 1]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$j+1];
                    $data[$j+1] = $temp;
                    $swap = true;
                }
            }

            if (!$swap) break;
        }

        return $data;
    }
}

class FastSortStrategy implements Strategy
{
    public function sort(array $data): array
    {
        echo PHP_EOL . "Sorting by fast sort ... ";
        sort($data);
        return $data;
    }
}

class Context
{
    private Strategy $strategy;

    public function setStrategy(Strategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function sort(array $data): array
    {
        return $this->strategy->sort($data);
    }
}

# Client code
$data = [10, 3, 5, 7, 1, 8, 15, 0];
$context = new Context();

$context->setStrategy(new FastSortStrategy());
print_r($context->sort($data));

$context->setStrategy(new BubbleSortStrategy());
print_r($context->sort($data));

echo PHP_EOL;