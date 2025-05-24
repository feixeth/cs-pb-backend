<?php

namespace App\Services;

class StrategyScoringService
{
    public function calculate(array $votes): int
    {
        return array_sum($votes);
    }
}
