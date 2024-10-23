<?php namespace App;

class Profile
{
    public string $name;
    public Type $type;
    public int $ppm, $magicItemAllowance = 0;
    public array $options, $upgrades, $statlines, $magicItemConditions = [];

    static function of(string $name, int $ppm, Type $type): self
    {
        $instance = new self;
        $instance->name = $name;
        $instance->ppm = $ppm;
        $instance->type = $type;
        return $instance;
    }

    function withOption(string $name, int $ppm): self
    {
        $instance = clone $this;
        $instance->options[$name] = $ppm;
        return $instance;
    }

    function withUpgrade(string $name, int $cost): self
    {
        $instance = clone $this;
        $instance->upgrades[$name] = $cost;
        return $instance;
    }

    function withStatline(string $name, array $statline): self
    {
        $instance = clone $this;
        $instance->statlines[$name] = $statline;
        return $instance;
    }

    public function withMagicItemAllowance(int $int, array $conditions): self
    {
        $instance = clone $this;
        $instance->magicItemAllowance = $int;
        $instance->magicItemConditions = $conditions;
        return $instance;
    }

    public function allowsMagicItems(): bool
    {
        return $this->magicItemAllowance > 0;
    }

    public function rejectsMagicItems(): bool
    {
        return !$this->allowsMagicItems();
    }
}
