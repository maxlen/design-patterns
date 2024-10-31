<?php

/**
 * GoF Proxy https://refactoring.guru/ru/design-patterns/proxy
 *
 * Proxy (Заместитель) — это структурный паттерн проектирования, который позволяет подставлять вместо реальных объектов
 * специальные объекты-заменители. Эти объекты перехватывают вызовы к оригинальному объекту, позволяя сделать что-то до
 * или после передачи вызова оригиналу.
 *
 * Написать программу, используя паттерн Proxy.
 *
 * Создайте к коду из примера Facade (./facade.php) кеширующий прокси - то есть прокси, который проверяет был ли
 * уже такой запрос и если был - отдает его из своей памяти. Если нет - помещает его в память.
 * Реализовывать очистку кеша и слежение за временем доступа не надо.
 *
 *  Решение на 118-й строке
 */

require_once "facade.php";

class Cache
{
    private array $storage;

    public function addToCache(string $key, $value): ?int
    {
        if (!isset($this->storage[$key])) {
            $this->storage[$key] = $value;
        }

        return $this->getCacheByKey($key);
    }

    public function getCacheByKey(string $key): ?int
    {
        if (!isset($this->storage[$key])) {
            return null;
        }

        return $this->storage[$key];
    }
}

class Proxy implements FacadeMathInterface
{

    public FacadeMathInterface $serviceFacade;
    public Cache $cache;

    public function __construct()
    {
        $this->serviceFacade = new FacadeMath();
        $this->cache = new Cache();
    }

    public function add(int $a, int $b): int
    {
        $key = "$a + $b";
        if (!empty($this->cache->getCacheByKey($key))) {
            $result = $this->cache->getCacheByKey($key);
            echo PHP_EOL . "Returned from cache key '{$key}' = {$result}" . PHP_EOL;
        } else {
            $result = $this->serviceFacade->add($a, $b);
            $this->cache->addToCache($key, $result);
            echo PHP_EOL . "Added to cache key '{$key}' = {$result}" . PHP_EOL;
        }

        return $result;
    }

    public function devide(int $a, int $b): int
    {
        $key = "$a / $b";
        if (!empty($this->cache->getCacheByKey($key))) {
            $result = $this->cache->getCacheByKey($key);
            echo PHP_EOL . "Returned from cache key '{$key}' = {$result}" . PHP_EOL;
        } else {
            $result = $this->serviceFacade->devide($a, $b);
            $this->cache->addToCache($key, $result);
            echo PHP_EOL . "Added to cache key '{$key}' = {$result}" . PHP_EOL;
        }

        return $result;
    }

    public function multiply(int $a, int $b): int
    {
        $key = "$a * $b";
        if (!empty($this->cache->getCacheByKey($key))) {
            $result = $this->cache->getCacheByKey($key);
            echo PHP_EOL . "Returned from cache key '{$key}' = {$result}" . PHP_EOL;
        } else {
            $result = $this->serviceFacade->multiply($a, $b);
            $this->cache->addToCache($key, $result);
            echo PHP_EOL . "Added to cache key '{$key}' = {$result}" . PHP_EOL;
        }

        return $result;
    }

    public function subtract(int $a, int $b): int
    {
        $key = "$a - $b";
        if (!empty($this->cache->getCacheByKey($key))) {
            $result = $this->cache->getCacheByKey($key);
            echo PHP_EOL . "Returned from cache key '{$key}' = {$result}" . PHP_EOL;
        } else {
            $result = $this->serviceFacade->multiply($a, $b);
            $this->cache->addToCache($key, $result);
            echo PHP_EOL . "Added to cache key '{$key}' = {$result}" . PHP_EOL;
        }

        return $result;
    }
}

/** Client code */
$proxy = new Proxy();
$proxy->add(2, 1) . PHP_EOL; // выведет: Added to cache key '2 + 1' = 3
$proxy->add(2, 1) . PHP_EOL; // выведет: Returned from cache key '2 + 1' = 3

echo PHP_EOL;

