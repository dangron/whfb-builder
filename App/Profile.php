<?php namespace App;

class Profile
{
    public string $name;
    public int $ppm;
    public array $options;
    public array $upgrades;

    static function of(string $name, int $ppm): self
    {
        $instance = new self;
        $instance->name = $name;
        $instance->ppm = $ppm;
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
}