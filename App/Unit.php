<?php namespace App;

class Unit
{
    public Profile $profile;
    public int $count;
    public array $options = [], $upgrades = [];

    public static function of(Profile $profile, int $count): self
    {
        $instance = new self;
        $instance->profile = $profile;
        $instance->count = $count;
        return $instance;
    }

    public function cost(): int
    {
        $baseCost = $this->profile->ppm * $this->count;
        $optionsCost = 0;
        foreach ($this->options as $selectedOption) {
            $optionsCost += $this->profile->options[$selectedOption] * $this->count;
        }
        $upgradesCost = 0;
        foreach ($this->upgrades as $selectedUpgrade) {
            $upgradesCost += $this->profile->upgrades[$selectedUpgrade];
        }
        return $baseCost + $optionsCost + $upgradesCost;
    }

    public function withOptions(string ...$names): self
    {
        $instance = clone $this;
        $instance->options = array_merge($instance->options, $names);
        return $instance;
    }

    public function withUpgrades(string ...$names): self
    {
        $instance = clone $this;
        $instance->upgrades = array_merge($instance->upgrades, $names);
        return $instance;
    }
}
