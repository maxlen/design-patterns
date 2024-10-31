<?php

/**
 * GoF Chain Of responsibility https://refactoring.guru/ru/design-patterns/chain-of-responsibility
 *
 * Цепочка обязанностей — это поведенческий паттерн проектирования, который позволяет передавать запросы последовательно
 * по цепочке обработчиков. Каждый последующий обработчик решает, может ли он обработать запрос сам и стоит ли
 * передавать запрос дальше по цепи.
 *
 * Написать программу, используя паттерн Chain Of Responsibility.
 *
 * - Вызов экстренной службы через единый интерфейс
 * - Можно вызвать:
 * - Пожарных
 * - Полицию
 * - Медицинскую помощь
 *
 *  Решение на 84-й строке
 */

interface Handler
{
    public function setNext(Handler $handler);
    public function handle(string $request);
}

abstract class BaseHandler implements Handler
{
    public Handler $nextHandler;
    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(string $request): ?string
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}

class FireHandler extends BaseHandler
{
    public function handle(string $request): ?string
    {
        if ($request == "01") {
            return "execute Fire service" . PHP_EOL;
        } else {
            return parent::handle($request);
        }
    }
}

class PoliceHandler extends BaseHandler
{
    public function handle(string $request): ?string
    {
        if ($request == "02") {
            return "execute Police service" . PHP_EOL;
        } else {
            return parent::handle($request);
        }
    }
}

class MedicalHandler extends BaseHandler
{
    public function handle(string $request): ?string
    {
        if ($request == "03") {
            return "execute Medical service" . PHP_EOL;
        } else {
            return parent::handle($request);
        }
    }
}

/** Client code */
$fire = new FireHandler();
$police = new PoliceHandler();
$medical = new MedicalHandler();

$fire->setNext($police)->setNext($medical);

// вызовет по очереди методы handle всех связанных выше сервисов
foreach (["01", "02", "03"] as $request) {
    echo "Client: call by phone number " . $request . PHP_EOL;
    $result = $fire->handle($request);
    if (!empty($result)) {
        echo "  " . $result;
    }
}

echo PHP_EOL;

