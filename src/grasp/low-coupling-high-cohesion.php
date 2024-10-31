<?php

/**
 * GRASP Low Coupling + High Cohesion
 *
 * https://habr.com/ru/companies/otus/articles/505852/
 *
 * Необходимо распределить ответственности между классами так, чтобы обеспечить минимальную связанность.
 *
 * с помощью класса Data (и его свойств c типами DateTemperature и DateTime ) я пытаюсь реализовать принцип High Cohesion + LowCoupling
 */

class DateTime
{
    private int $time;

    private function calculateTimeDifference(int $time): int
    {
        return $this->time - $time;
    }
}

class DateTemperature
{
    private int $temperature;

    private function calculateTemperatureDifference(int $temperature): int
    {
        return $this->temperature - $temperature;
    }
}

class Data
{
    private DateTime $dateTime;
    private DateTemperature $dateTemperature;

    public function __construct(int $time, int $temperature) {
        $this->dateTime = new DateTime($time);
        $this->dateTemperature = new DateTemperature($temperature);
    }

    // other logic
}

// Client code
$data = new Data(time: 10, temperature: 25);



