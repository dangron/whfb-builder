<?php

use App\Profile;
use App\Type;
use App\Unit;

test('units can select options which have a points cost per model', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core)
        ->withOption('Poisoned Attacks', 3)
        ->withOption('Scaly Skin (6+)', 1);

    $normalDogs = Unit::of($warhoundsProfile, 5);
    expect($normalDogs->selectedOptions)->toBe([]);
    expect($normalDogs->cost())->toBe(30);

    $poisonDogs = Unit::of($warhoundsProfile, 5)->withOptions('Poisoned Attacks');
    expect($poisonDogs->selectedOptions)->toBe(['Poisoned Attacks']);
    expect($poisonDogs->cost())->toBe(45);

    $scalyPoisonDogs = Unit::of($warhoundsProfile, 5)->withOptions('Scaly Skin (6+)', 'Poisoned Attacks');
    expect($scalyPoisonDogs->selectedOptions)->toBe(['Scaly Skin (6+)', 'Poisoned Attacks']);
    expect($scalyPoisonDogs->cost())->toBe(50);
});

test('units can select upgrades for a flat points cost', function () {
    $marauderProfile = Profile::of('Marauders', 4, Type::Core)
        ->withUpgrade('Musician', 4)
        ->withUpgrade('Standard Bearer', 8)
        ->withUpgrade('Chieftain', 8);
    $marauderUnit = Unit::of($marauderProfile, 10)
        ->withUpgrades('Musician', 'Standard Bearer', 'Chieftain');
    expect($marauderUnit->cost())->toBe(60);
    expect($marauderUnit->selectedUpgrades)->toBe(['Musician', 'Standard Bearer', 'Chieftain']);
});

test('units can violate unit size constraints', function () {
    $marauderProfile = Profile::of('Marauders', 4, Type::Core)
        ->withUpgrade('Musician', 4)
        ->withUpgrade('Standard Bearer', 8)
        ->withUpgrade('Chieftain', 8)
        ->withMinUnitSize(10);
    $marauderUnit = Unit::of($marauderProfile, 10)
        ->withUpgrades('Musician', 'Standard Bearer', 'Chieftain');
    expect($marauderUnit->cost())->toBe(60);
    expect($marauderUnit->selectedUpgrades)->toBe(['Musician', 'Standard Bearer', 'Chieftain']);
});
