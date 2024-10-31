<?php

/**
 * State (Состояние) — это поведенческий паттерн проектирования, который позволяет объектам менять поведение в
 * зависимости от своего состояния. Извне создаётся впечатление, что изменился класс объекта.
 *
 * https://refactoring.guru/ru/design-patterns/state
 *
 * Написать программу, используя паттерн State:
 *
 * Печь для приготовления пиццы
 * Состояния:
 *  - Холодная
 *  - Готова к работе
 *  - Перегрев
 * И методы перехода между состояниями
 *
 * А так же метод bake() который ведет себя по разному в зависимости от того, в каком состоянии печь - в не прогретом
 * и в перегретом кидает эксепшены, а в нормальном - работает
 *
 *  Решение на 79-й строке
 */

abstract class State
{
    public Oven $oven;

    public function __construct(Oven $oven)
    {
        $this->oven = $oven;
    }

    abstract public function bake();
}

class ColdState extends State
{
    public function bake()
    {
        $this->oven->changeState($this);
        throw new Exception('Печь слишком холодная :(');
    }
}

class ReadyState extends State
{
    public function bake()
    {
        $this->oven->changeState($this);
        echo PHP_EOL . "Печь в подходящем состоянии для выпечкания! :)";
    }
}

class HotState extends State
{
    public function bake()
    {
        $this->oven->changeState($this);
        throw new Exception('Печь слишком горячая :(');
    }
}

class Oven
{
    public State $state;

    public function changeState(State $state)
    {
        $this->state = $state;
    }

    public function bake()
    {
        $this->state->bake();
    }
}

# Client code
$oven = new Oven();
$state = new ColdState($oven);
$oven->changeState($state);
try {
    $oven->bake();
} catch (Exception $e) {
    echo $e->getMessage(); // выводит текст эксепшина ("Печь слишком холодная :(")
}

$state = new ReadyState($oven);
$oven->changeState($state);
$oven->bake(); // выводит текст ("Печь в подходящем состоянии для выпечкания! :)")

echo PHP_EOL;