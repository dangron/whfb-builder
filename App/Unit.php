<?php namespace App;

use App\Exception\InvalidSelectionException;

class Unit
{
    public Profile $profile;
    public int $count;
    public array $selectedOptions = [], $selectedUpgrades = [], $selectedMagicItems = [];

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
        $magicItemCost = array_sum($this->selectedMagicItems);
        return $baseCost + $optionsCost + $upgradesCost + $magicItemCost;
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

    public function withMagicItem(string $name, int $cost): self
    {
        $hasRequiredUpgrade = $this->profile->magicItemConditions['require-upgrade'] ?? false;
        if ($hasRequiredUpgrade && !$this->hasUpgrade($this->profile->magicItemConditions['require-upgrade'])){
            throw new InvalidSelectionException;
        }
        $magicItemLimit = $this->profile->magicItemConditions['limit'] ?? false;
        if ($magicItemLimit && $this->countMagicItems() >= $magicItemLimit) {
            throw new InvalidSelectionException;
        }
        if (!$this->profile->allowsMagicItems() || $this->magicItemAllowanceRemaining() < $cost) {
            throw new InvalidSelectionException;
        }
        $instance = clone $this;
        $instance->selectedMagicItems = array_merge($instance->selectedMagicItems, [$name => $cost]);
        return $instance;
    }

    private function magicItemAllowanceRemaining(): int
    {
        $magicItemsPointsSpent = array_sum($this->selectedMagicItems);
        return $this->profile->magicItemAllowance - $magicItemsPointsSpent;
    }

    private function hasUpgrade(string $upgradeName): bool
    {
        return in_array($upgradeName, $this->selectedUpgrades);
    }

    private function countMagicItems(): int
    {
        return count($this->selectedMagicItems);
    }
}
