<?php

/**
 * GRASP Information Expert (Информационный эксперт) https://habr.com/ru/companies/otus/articles/491636/
 *
 * Избегая наукообразных формулировок, суть данного паттерна можно выразить следующим образом: информация должна
 * обрабатываться там, где она содержится.
 *
 * Задача. Написать программу, используя паттерн Information Expert:
 *
 * Создайте адаптер для класса, имеющего интерфейс на не английском языке, достаточно одного-двух методов
 *
 *  Решение на 63-й строке
 */

class OrderItem
{
    public function __construct(
        private int $quantity,
        private float $pricePerOne)
    {
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPricePerOne(): float
    {
        return $this->pricePerOne;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setPricePerOne(float $pricePerOne): self
    {
        $this->pricePerOne = $pricePerOne;

        return $this;
    }
}

class Order
{
    public function __construct(
        /** @var OrderItem[] */
        private array $orderItems = []
    )
    {
    }

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }
}

class CashRegister
{
    public function getCheckSumm(Order $order): float
    {
        $sum = 0;

        foreach ($order->getOrderItems() as $item) {
            $sum += $item->getQuantity() * $item->getPricePerOne();
        }

        return $sum;
    }
}


// Client code
$order = new Order(
    [
        new OrderItem(1, 10.00),
        new OrderItem(2, 20.00),
    ]
);

// с помощью класса CashRegister (кассовый аппарат) реализовываем принцип InformationalExpert
$cacheRegister = new CashRegister();
echo $cacheRegister->getCheckSumm($order);
echo PHP_EOL;
