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

    function cost(?Type $type = null): int
    {
        return array_reduce(
            $type ? $this->filterUnitsByType($type): $this->units,
            fn($carry, $unit) => $carry + $unit->cost(), 0
        );
    }

    private function filterUnitsByType(Type $type): array
    {
        return array_filter($this->units, fn(Unit $unit) => $unit->profile->type === $type);
    }

    public function unitCount(?Type $type = null): int
    {
        return array_reduce(
            $type ? $this->filterUnitsByType($type): $this->units,
            fn($carry, $unit) => $carry + 1, 0
        );
    }
}
