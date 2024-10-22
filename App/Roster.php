<?php namespace App;

class Roster
{
    private array $units;

    static function of(Unit ...$units): self
    {
        $instance = new self;
        $instance->units = $units;
        return $instance;
    }

    function cost(): int
    {
        return array_reduce(
            $this->units,
            fn($carry, $unit) => $carry + $unit->cost(), 0
        );
    }
}
