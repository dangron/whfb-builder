<?php

use App\Profile;
use App\Roster;
use App\Unit;

test('units have costs', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6);
    $warhoundsUnit = Unit::of($warhoundsProfile, 5);
    expect($warhoundsUnit->cost())->toBe(30);
});

test('units and profiles can have multiple options', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6)
        ->withOption('Poisoned Attacks', 3)
        ->withOption('Scaly Skin (6+)', 1);
    $warhoundsUnit = Unit::of($warhoundsProfile, 5)
        ->withOptions('Poisoned Attacks', 'Scaly Skin (6+)');
    expect($warhoundsUnit->cost())->toBe(50);
});

test('units and profiles can have upgrades', function () {
    $marauderProfile = Profile::of('Marauders', 4)
        ->withUpgrade('Musician', 4)
        ->withUpgrade('Standard Bearer', 8)
        ->withUpgrade('Chieftain', 8)
        ->withOption('Light Armour', 1)
        ->withOption('Shields', 1);
    $marauderUnit = Unit::of($marauderProfile, 10)
        ->withUpgrades('Musician', 'Standard Bearer', 'Chieftain')
        ->withOptions('Shields');
    expect($marauderUnit->cost())->toBe(70);
});

test('rosters have costs', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6);
    $warhoundsUnitA = Unit::of($warhoundsProfile, 5);
    $warhoundsUnitB = Unit::of($warhoundsProfile, 5);
    $roster = Roster::of($warhoundsUnitA, $warhoundsUnitB);
    expect($roster->cost())->toBe(60);
});