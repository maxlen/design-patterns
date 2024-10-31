<?php

/**
 * Memento — это поведенческий паттерн проектирования, который позволяет сохранять и восстанавливать прошлые состояния
 * объектов, не раскрывая подробностей их реализации.
 *
 * https://refactoring.guru/ru/design-patterns/memento
 *
 * Написать программу, используя паттерн Memento:
 *
 * Текстовый редактор
 * Есть функции:
 * - Сохранять новую версию документа
 * - Возвращать определенную версию документа
 *
 *  Решение на 96-й строке
 */

class Editor
{
    // fields
    private string $text;
    private int $curX;
    private int $curY;

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setCurXY(int $curX, int $curY): void
    {
        $this->curX = $curX;
        $this->curY = $curY;
    }

    public function createSnapshot(): Snapshot
    {
        return new Snapshot($this, $this->text, $this->curX, $this->curY);
    }
}

interface Memento
{
    public function restore();
}

class Snapshot implements Memento
{
    private Editor $editor;
    // fields
    private string $text;
    private int $curX;
    private int $curY;

    public function __construct(Editor $editor, string $text, int $curX, int $curY)
    {
        $this->editor = $editor;
        $this->text = $text;
        $this->curX = $curX;
        $this->curY = $curY;
    }

    public function restore(): Editor
    {
        $this->editor->setText($this->text);
        $this->editor->setCurXY($this->curX, $this->curY);

        return $this->editor;
    }
}

class Command
{
    private Snapshot $backup;

    public function __construct(public Editor $editor)
    {
    }

    public function createBackup()
    {
        $this->backup = $this->editor->createSnapshot();
    }

    public function undo()
    {
        if (!is_null($this->backup)) {
            $this->backup->restore();
        }
    }

}

# Client code
$editor = new Editor;
$editor->setText("Text1");
$editor->setCurXY(1, 11);
print_r($editor); // print editor with: text = Text1, curX=1, curY=11

$command = new Command($editor);
$command->createBackup();

$editor->setText("Text2");
$editor->setCurXY(2, 22);
print_r($editor); // print editor with: text = Text2, curX=2, curY=22

$command->undo();
print_r($editor); // print editor with: text = Text1, curX=1, curY=11