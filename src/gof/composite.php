<?php

/**
 * Задача на GoF шаблон Composite (Компоновщик):
 * https://refactoring.guru/ru/design-patterns/composite
 *
 * Создайте дерево объектов, позволяющее инкрементировать и декрементировать значение
 * целого поля по всем нижележащим элементам дерева
 *
 *  Решение на 95-й строке
 */

interface ElementInterface
{
    public function incrementI();

    public function decrementI();

    public function execute();
}

abstract class Element implements ElementInterface
{
    public int $i = 0;

    public function __construct(int $i)
    {
        $this->i = $i;
    }

    public function incrementI() {
        $this->i++;
    }

    public function decrementI() {
        $this->i--;
    }

    abstract public function execute(): string;

    abstract public function incrementAllChildren(): void;

    abstract public function decrementAllChildren(): void;
}


class NodeComposite extends Element
{
    /** @var Element[] */
    private array $children = [];

    public function add(Element $child): void
    {
        $this->children[] = $child;
    }

    public function execute(): string
    {
        $results = [];
        foreach ($this->children as $child) {
            $results[] = $child->execute();
        }

        return PHP_EOL . "I am Node (" . $this->i . ':' . implode("+", $results) . ")";
    }

    public function incrementAllChildren(): void
    {
        foreach ($this->children as $child) {
            $child->incrementI();
            $child->incrementAllChildren();
        }
    }

    public function decrementAllChildren(): void
    {
        foreach ($this->children as $child) {
            $child->decrementI();
            $child->decrementAllChildren();
        }
    }
}

class Leaf extends Element
{
    public function execute(): string
    {
        return PHP_EOL . "I am leaf: " . $this->i;
    }

    public function incrementAllChildren(): void {}

    public function decrementAllChildren(): void {}
}

// простое дерево tree
$branch = new NodeComposite(1);
$branch->add(new Leaf(2));
echo PHP_EOL . "Начальные значения дерева:" . PHP_EOL;
echo $branch->execute() . PHP_EOL;

echo PHP_EOL . "Значения дерева после инкремента в дочерних элементах:" . PHP_EOL;
$branch->incrementAllChildren();
echo $branch->execute() . PHP_EOL;

echo PHP_EOL . '---------------------' . PHP_EOL;

// сложное дерево
$tree = new NodeComposite(1);
$branch1 = new NodeComposite(2);
$branch2 = new NodeComposite(2);
$branch2->add(new Leaf(3));
$branch2->add(new Leaf(3));
$branch1->add($branch2);
$tree->add($branch1);

echo PHP_EOL . "Начальные значения дерева:" . PHP_EOL;
echo $tree->execute() . PHP_EOL;

echo PHP_EOL . "Значения дерева после инкремента в дочерних элементах:" . PHP_EOL;
$tree->incrementAllChildren();
echo $tree->execute() . PHP_EOL;

echo PHP_EOL . "Значения дерева после декремента в дочерних элементах:" . PHP_EOL;
$tree->decrementAllChildren();
echo $tree->execute() . PHP_EOL;