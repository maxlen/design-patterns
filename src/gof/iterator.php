<?php

/**
 * Написать программу, используя паттерн Iterator (Итератор).
 * https://refactoring.guru/ru/design-patterns/iterator
 * Итератор — это поведенческий паттерн проектирования, который даёт возможность последовательно обходить элементы
 * составных объектов, не раскрывая их внутреннего представления.
 *
 * Создайте к списку из книг (Имя автора, Название, год издания) три итератора, пробегающие список книг соответственно
 * по трем полям по возрастанию
 *
 *  Решение на 127-й строке
 */

class Book {
    public function __construct(
        public readonly string $author,
        public readonly string $title,
        public readonly int $year,
    )
    {
    }
}

class BookCollection {
    private $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(Book $item)
    {
        $this->items[] = $item;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function getYearIterator()
    {
        return new YearIterator($this);
    }

    public function getTitleIterator()
    {
        return new TitleIterator($this);
    }

    public function getAuthorIterator()
    {
        return new AuthorIterator($this);
    }
}

class BookIterator implements \Iterator
{
    protected BookCollection $collection;

    protected $position = 0;

    public function __construct(BookCollection $collection) {}

    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    public function next()
    {
        $this->position = $this->position + 1;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection->getItems()[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}

class YearIterator extends BookIterator
{
    public function __construct(BookCollection $collection)
    {
        $this->collection = $collection;
        $items = $this->collection->getItems();
        usort($items, fn($a, $b) => strcmp($a->year, $b->year));
        $this->collection->setItems($items);
    }
}

class TitleIterator extends BookIterator
{
    public function __construct(BookCollection $collection)
    {
        $this->collection = $collection;
        $items = $this->collection->getItems();
        usort($items, fn($a, $b) => strcmp($a->title, $b->title));
        $this->collection->setItems($items);
    }
}

class AuthorIterator extends BookIterator
{
    public function __construct(BookCollection $collection)
    {
        $this->collection = $collection;
        $items = $this->collection->getItems();
        usort($items, fn($a, $b) => strcmp($a->author, $b->author));
        $this->collection->setItems($items);
    }
}

# Client code
$collection = new BookCollection();
$collection->addItem(new Book('Autor1', 'Title 2', 2020));
$collection->addItem(new Book('Autor2', 'Title 1', 2008));
$collection->addItem(new Book('Autor3', 'Title 3', 2010));

echo PHP_EOL. "Print title by year: " . PHP_EOL;
foreach ($collection->getYearIterator() as $item) {
    print_r($item);
}

echo PHP_EOL. "Print title by title: " . PHP_EOL;
foreach ($collection->getTitleIterator() as $item) {
    print_r($item);
}

echo PHP_EOL. "Print sorted by author: " . PHP_EOL;
foreach ($collection->getAuthorIterator() as $item) {
    print_r($item);
}

echo PHP_EOL;
