<?php

/**
 * Template Method — это поведенческий паттерн проектирования, который определяет скелет алгоритма, перекладывая
 * ответственность за некоторые его шаги на подклассы. Паттерн позволяет подклассам переопределять шаги алгоритма,
 * не меняя его общей структуры.
 *
 * https://refactoring.guru/ru/design-patterns/template-method
 *
 * Написать программу, используя паттерн Template Method:
 * - Программа для записи информации в файл
 * - Записать текущую дату
 * - Записать текущее время
 *
 *  Решение на 71-й строке
 */

abstract class AbstractWriterClass
{
    public $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    final public function templateMethod(string $content)
    {
        $this->writeDate();
        $this->writeTime();
        $this->writeSomeData($content);
    }

    public function writeDate()
    {
        $this->writeToFile(PHP_EOL . date("Y-m-d"));
    }

    public function writeTime()
    {
        $this->writeToFile(PHP_EOL . date("H:i:s"));
    }

    abstract public function writeSomeData(string $content);

    public function writeToFile(string $data)
    {
        file_put_contents($this->filePath, $data, FILE_APPEND);
    }
}

class WriterToFile1 extends AbstractWriterClass
{
    public function writeSomeData(string $content)
    {
        $content = '-1- ' . $content . ' -1-';
        $this->writeToFile(PHP_EOL . $content);
    }
}

class WriterToFile2 extends AbstractWriterClass
{
    public function writeSomeData(string $content)
    {
        $content = '-2- ' . $content . ' -2-';
        $this->writeToFile(PHP_EOL . $content);
    }
}

# Client code
$writer1 = new WriterToFile1('writerTest.txt');
$writer1->templateMethod('data from writer1');

$writer2 = new WriterToFile2('writerTest.txt');
$writer2->templateMethod('data from writer2');
