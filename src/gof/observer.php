<?php

/**
 * Observer — это поведенческий паттерн проектирования, который создаёт механизм подписки, позволяющий одним объектам
 * следить и реагировать на события, происходящие в других объектах.
 *
 * https://refactoring.guru/ru/design-patterns/observer
 *
 * Написать программу, используя паттерн Observer:

 * Сервис предупреждения о штормах^
 * - Может извещать подписчиков о наступлении шторма
 * - Разные подписчики - школы, аэропорт, дорожные службы реагируют на разный уровень предупреждения
 *
 *  Решение на 96-й строке
 */

class StormServiceNotifier implements SplSubject
{
    private int $status = 0;

    /** @var SplObserver[] */
    private array $observers = [];

    public function getStatus(): int
    {
        return $this->status;
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        $key = array_search($observer, $this->observers);
        unset($this->observers[$key]);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function someBusinessLogic()
    {
        $this->status = rand(0, 10);
        $this->notify();
    }
}

class Subscriber1 implements SplObserver
{
    public function update(SplSubject $subject)
    {
        if ($subject->getStatus() %2 == 0) {
            echo PHP_EOL . "Doing some logic after notified from class " . self::class . ". Notifier status = {$subject->getStatus()}";
        }
    }
}

class Subscriber2 implements SplObserver
{
    public function update(SplSubject $subject)
    {
        if ($subject->getStatus() %2 != 0) {
            echo PHP_EOL . "Doing some logic after notified from class " . self::class . ". Notifier status = {$subject->getStatus()}";
        }
    }
}

# Client code
$notifier = new StormServiceNotifier();

$subscriber1 = new Subscriber1();
$notifier->attach($subscriber1);

$subscriber2 = new Subscriber2();
$notifier->attach($subscriber2);

$notifier->someBusinessLogic();

$notifier->detach($subscriber2);
$notifier->someBusinessLogic();

echo PHP_EOL;