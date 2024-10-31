<?php

/**
 * GRASP Creator
 * https://habr.com/ru/companies/otus/articles/505618/
 *
 * Данный паттерн решает такую же типовую задачу как и его предшественник: создавать экземпляры класса должен класс,
 * которому они нужны.
 *
 * с помощью класса Order (заказ) мы реализовываем принцип Creator
 */
class Good
{
    public function __construct(
        private string $name,
        private float $price)
    {
    }

    public function getName(): int
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}

class OrderItem
{
    private Good $good;
    public function __construct(
        private int $amount,
        string $name,
        float $price)
    {
        $this->good = new Good($name, $price);
    }

    public function getPrice(): float
    {
        return $this->amount * $this->good->getPrice();
    }
}

class Order
{
    /** @var OrderItem[] */
    private array $orderItems;

    public function addOrderItem(int $amount, string $name, float $price): void
    {
        $this->orderItems[] = new OrderItem($amount, $name, $price);
    }

    public function getPriceSum(): float
    {
        $priceSum = 0;

        foreach($this->orderItems as $orderItem) {
            $priceSum += $orderItem->getPrice();
        }

        return $priceSum;
    }
}

// Client code
$order = new Order();
$order->addOrderItem(1, 'пряник', 13.50);
$order->addOrderItem(2, 'кефир', 30);

echo $order->getPriceSum() . PHP_EOL;
