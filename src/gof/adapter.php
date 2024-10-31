<?php

/**
 * GoF Adapter https://refactoring.guru/ru/design-patterns/adapter
 *
 * Написать программу, используя паттерн Adapter.
 *
 * Создайте адаптер для класса, имеющего интерфейс на не английском языке, достаточно одного-двух методов
 *
 *  Решение на 63-й строке
 */

interface ForeignInterface
{
    public function getForeignTitle(): string;
    public function getForeignDescription(): string;
}

class GermanClass implements ForeignInterface
{
    public function getForeignTitle(): string
    {
        return 'Mötley Crüe';
    }

    public function getForeignDescription(): string
    {
        return 'im Institut für Internationale Kommunikation und Auswärtige Kulturarbeit e.V.IIK Bayreuth';
    }
}

interface EnglishInterface
{
    public function setForeignSource(ForeignInterface $foreignSource);
    public function getTranslatedTitle(): string;
    public function getTranslatedDescription(): string;
}

class Adapter implements EnglishInterface
{
    public ForeignInterface $foreignSource;

    public function setForeignSource(ForeignInterface $foreignSource): void
    {
        $this->foreignSource = $foreignSource;
    }

    public function getTranslatedTitle(): string
    {
        // TODO: logic with translation $this->>foreignSource->getTitle()
        $translated = 'Translated title: ' . $this->foreignSource->getForeignTitle();

        return $translated;
    }

    public function getTranslatedDescription(): string
    {
        // TODO: logic with translation $this->>foreignSource->getDescription()
        $translated = 'Translated description: ' . $this->foreignSource->getForeignDescription();

        return $translated;
    }
}

// Client code
$foreignSource = new GermanClass();
$adapter = new Adapter();
$adapter->setForeignSource($foreignSource);

echo $adapter->getTranslatedTitle();
echo PHP_EOL;
echo $adapter->getTranslatedDescription();

echo PHP_EOL;

