<?php

use App\Profile;
use App\Roster;
use App\Type;
use App\Unit;

test('units have costs', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core);
    $warhoundsUnit = Unit::of($warhoundsProfile, 5);
    expect($warhoundsUnit->cost())->toBe(30);
});

test('units and profiles can have multiple options', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core)
        ->withOption('Poisoned Attacks', 3)
        ->withOption('Scaly Skin (6+)', 1);
    $warhoundsUnit = Unit::of($warhoundsProfile, 5)
        ->withOptions('Poisoned Attacks', 'Scaly Skin (6+)');
    expect($warhoundsUnit->cost())->toBe(50);
});

test('units and profiles can have upgrades', function () {
    $marauderProfile = Profile::of('Marauders', 4, Type::Core)
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
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core);
    $warhoundsUnitA = Unit::of($warhoundsProfile, 5);
    $warhoundsUnitB = Unit::of($warhoundsProfile, 5);
    $roster = Roster::of($warhoundsUnitA, $warhoundsUnitB);
    expect($roster->cost())->toBe(60);
});

test('profiles can have multiple statlines', function () {
    $marauderStats = ['m' => 4, 'ws' => 4, 'bs' => 3, 's' => 3, 't' => 3, 'w' => 1, 'i' => 4, 'a' => 1, 'Ld' => 7];
    $marauderChieftainStats = array_merge($marauderStats, ['a' => 2]);
    $profile = Profile::of('Marauders', 4, Type::Core)
        ->withStatline('Marauder', $marauderStats)
        ->withStatline('Chieftain', $marauderChieftainStats);
    expect($profile->statlines['Marauder']['a'])->toBe(1);
    expect($profile->statlines['Chieftain']['a'])->toBe(2);
});

test('rosters organise units by their type', function () {
    $lordsProfile = Profile::of('Chaos Lord', 210, Type::Lords);
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core);
    $roster = Roster::of(
        Unit::of($lordsProfile, 1),
        Unit::of($warhoundsProfile, 5),
        Unit::of($warhoundsProfile, 10)
    );
    expect($roster->cost())->toBe(300);
    expect($roster->cost(Type::Lords))->toBe(210);
    expect($roster->cost(Type::Core))->toBe(90);
    expect($roster->cost(Type::Special))->toBe(0);
});

test('rosters count units by their type', function () {
    $lordsProfile = Profile::of('Chaos Lord', 210, Type::Lords);
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core);
    $roster = Roster::of(
        Unit::of($lordsProfile, 1),
        Unit::of($warhoundsProfile, 5),
        Unit::of($warhoundsProfile, 10)
    );
    expect($roster->unitCount())->toBe(3);
    expect($roster->unitCount(Type::Lords))->toBe(1);
    expect($roster->unitCount(Type::Core))->toBe(2);
    expect($roster->unitCount(Type::Special))->toBe(0);
});
