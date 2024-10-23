<?php

use App\Profile;
use App\Type;

test('profiles can have options', function () {
    $warhoundsProfile = Profile::of('Warhounds', 6, Type::Core)
        ->withOption('Poisoned Attacks', 3)
        ->withOption('Scaly Skin (6+)', 1);
    expect(count($warhoundsProfile->options))->toBe(2);
});

test('profiles can have upgrades', function () {
    $marauderProfile = Profile::of('Marauders', 4, Type::Core)
        ->withUpgrade('Musician', 4)
        ->withUpgrade('Standard Bearer', 8)
        ->withUpgrade('Chieftain', 8);
    expect(count($marauderProfile->upgrades))->toBe(3);
});

test('profiles can specify a unit size', function () {
    $marauderProfile = Profile::of('Marauders', 4, Type::Core)->withMinUnitSize(10);
    expect($marauderProfile->minUnitSize)->toBe(10);
    expect($marauderProfile->maxUnitSize)->toBeNull();
    $hero = Profile::hero('Exalted Hero', 110);
    expect($hero->maxUnitSize)->toBe(1);
    expect($hero->minUnitSize)->toBe(1);
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
