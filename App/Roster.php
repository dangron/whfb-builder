<?php namespace App;

class Roster
{
    private array $units;
    private ?int $pointsLimit;

    static function of(Unit ...$units): self
    {
        $instance = new self;
        $instance->units = $units;
        return $instance;
    }

    public static function empty()
    {
        return self::of();
    }

    public function addUnit(Unit $unit)
    {
        $this->units[] = $unit;
    }

    function cost(?Type $type = null): int
    {
        return array_reduce(
            $type ? $this->filterUnitsByType($type): $this->units,
            fn($carry, Unit $unit) => $carry + $unit->cost(), 0
        );
    }

    public function unitCount(?Type $type = null): int
    {
        return array_reduce(
            $type ? $this->filterUnitsByType($type): $this->units,
            fn($carry, Unit $unit) => $carry + 1, 0
        );
    }

    public function modelCount(?Type $type = null): int
    {
        return array_reduce(
            $type ? $this->filterUnitsByType($type): $this->units,
            fn($carry, Unit $unit) => $carry + $unit->count, 0
        );
    }

    private function filterUnitsByType(Type $type): array
    {
        return array_filter($this->units, fn(Unit $unit) => $unit->profile->type === $type);
    }

    public function setPointsLimit(int $int): self
    {
        $this->pointsLimit = $int;
        return $this;
    }

    public function pointsLeft(): ?int
    {
        if ($this->pointsLimit === null) {
            return null;
        }
        return $this->pointsLimit - $this->cost();
    }
}
