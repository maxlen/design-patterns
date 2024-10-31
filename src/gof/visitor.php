    <?php

    /**
     * https://refactoring.guru/ru/design-patterns/visitor
     * Visitor — это поведенческий паттерн проектирования, который позволяет добавлять в программу новые операции,
     * не изменяя классы объектов, над которыми эти операции могут выполняться.
     *
     * Написать программу, используя паттерн Visitor (Посетитель).
     * Готовим пиццу
     * По кастомному рецепту от пользователя, содержащему:
     * - Сыр
     * - Бекон
     * - Ананасы
     * - Грибы
     * - Морепродукты
     *
     *  Решение на 69-й строке
     */

    interface VisitorInterface {
        public function visitThinPizza(ThinPizza $pizza);
        public function visitThickPizza(ThickPizza $pizza);
    }

    class VisitorCheese implements VisitorInterface {
        public function visitThinPizza(ThinPizza $pizza) {
            echo "add cheese to the pizza";
            $pizza->addIngredient('cheese');
        }

        public function visitThickPizza(ThickPizza $pizza) {
            echo "add cheese to the to pizza";
            $pizza->addIngredient('cheese');
        }
    }

    class VisitorBacon implements VisitorInterface {
        public function visitThinPizza(ThinPizza $pizza) {
            echo "add bacon to the pizza";
            $pizza->addIngredient('bacon');
        }

        public function visitThickPizza(ThickPizza $pizza) {
            echo "add bacon to the to pizza";
            $pizza->addIngredient('bacon');
        }
    }

    abstract class AbstractPizza {
        public array $ingredients = [];
        public function addIngredient(string $ingredient) {
            $this->ingredients[] = $ingredient;
        }
    }

    class ThinPizza extends AbstractPizza {
        public function accept(VisitorCheese $visitor) {
            $visitor->visitThinPizza($this);
        }
    }

    class ThickPizza extends AbstractPizza {
        public function accept(VisitorBacon $visitor) {
            $visitor->visitThickPizza($this);
        }
    }

    # Client code
    $thinPizza = new ThinPizza();
    $thinPizza->accept(new VisitorCheese());
    var_dump($thinPizza);

    $thickPizza = new ThickPizza();
    $thickPizza->accept(new VisitorBacon());
    var_dump($thickPizza);
    echo PHP_EOL;
