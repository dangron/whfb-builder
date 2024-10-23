<?php namespace App;

class Unit
{
    public Profile $profile;
    public int $count;
    public array $selectedOptions = [], $selectedUpgrades = [];

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
        foreach ($this->selectedOptions as $selectedOption) {
            $optionsCost += $this->profile->options[$selectedOption] * $this->count;
        }
        $upgradesCost = 0;
        foreach ($this->selectedUpgrades as $selectedUpgrade) {
            $upgradesCost += $this->profile->upgrades[$selectedUpgrade];
        }
        return $baseCost + $optionsCost + $upgradesCost;
    }

    public function withOptions(string ...$names): self
    {
        $instance = clone $this;
        $instance->selectedOptions = array_merge($instance->selectedOptions, $names);
        return $instance;
    }

    public function withUpgrades(string ...$names): self
    {
        $instance = clone $this;
        $instance->selectedUpgrades = array_merge($instance->selectedUpgrades, $names);
        return $instance;
    }
}
