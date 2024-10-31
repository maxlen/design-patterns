<?php

/**
 * Mediator — это поведенческий паттерн проектирования, который позволяет уменьшить связанность множества классов
 * между собой, благодаря перемещению этих связей в один класс-посредник.
 *
 * https://refactoring.guru/ru/design-patterns/mediator
 *
 * Написать программу, используя паттерн Mediator:
 *
 * Консьерж сервис
 * Можно давать задания на:
 * - Вызов такси
 * - Вызов мастера на дом
 * - Доставку цветов
 * и нотифицировать отправителя, не связывая их напрямую
 *
 *  Решение на 107-й строке
 */

const FLOWER_SERVICE = 'flowerService';
const HOME_SERVICE = 'homeService';
const TAXI_SERVICE = 'taxiService';

abstract class UserAbstract
{
    public string $name;
    public string $address;

    public function __construct(string $name, string $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    abstract public function call(string $info);
}

class User extends UserAbstract
{
    public function call(string $info)
    {
        echo "Got info from service: " . $info . PHP_EOL;
    }

    public function callToService(string $serviceName)
    {
        $mediator = new Mediator();
        $mediator->executeService($serviceName, $this);
    }
}

interface ServiceInterface
{
    public function execute(UserAbstract $user): string;
}

class TaxiService implements ServiceInterface
{
    public function execute(UserAbstract $user): string
    {
        return "executed taxiService for " . $user->name. PHP_EOL . 'Taxi to: ' . $user->address. PHP_EOL;
    }
}

class HomeMasterService implements ServiceInterface
{
    public function execute(UserAbstract $user): string
    {
        return "executed HomeMasterService for " . $user->name. PHP_EOL . 'Service by address: ' . $user->address. PHP_EOL;
    }
}

class FlowersService implements ServiceInterface
{
    public function execute(UserAbstract $user): string
    {
        return "executed FlowersService for " . $user->name. PHP_EOL . 'Delivery to: ' . $user->address. PHP_EOL;
    }
}

class Mediator
{
    public function executeService(string $serviceName, UserAbstract $user)
    {
        switch ($serviceName) {
            case FLOWER_SERVICE:
                $service = new FlowersService();
                break;
            case HOME_SERVICE:
                $service = new HomeMasterService();
                break;
            case TAXI_SERVICE:
                $service = new TaxiService();
                break;
            default:
                throw new Exception('cant find service');
        }

        $serviceResponse = $service->execute($user);

        $user->call($serviceResponse);
    }
}

# Client code
$user1 = new User('Vasya', 'podval');
$user2 = new User('Mykola', 'cherdak');

$user1->callToService(FLOWER_SERVICE); // Got info from service: executed FlowersService for Vasya. Delivery to: podval
$user2->callToService(TAXI_SERVICE); // Got info from service: executed taxiService for Mykola. Taxi to: cherdak
