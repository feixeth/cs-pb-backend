<?php
use App\Services\StrategyScoringService;

// to dig more : it seems that i've misudnerstood somethin since with the code i have i dont see point to make unit


it('calculates the score from an array of votes', function () {
    $service = new StrategyScoringService();

    expect($service->calculate([1, 1, -1]))->toBe(1);
    expect($service->calculate([]))->toBe(0);
    expect($service->calculate([-1, -1, -1]))->toBe(-3);
});
